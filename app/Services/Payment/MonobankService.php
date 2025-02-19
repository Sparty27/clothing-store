<?php

namespace App\Services\Payment;

use App\Enums\PaymentStatusEnum;
use App\Models\Order;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Client\PendingRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class MonobankService
{
    private $token;
    private $domain;
    private $pubkey;
    
    public function __construct()
    {
        $this->token = config('monobank.token');
        $this->domain = config('monobank.domain');
        $this->pubkey = config('monobank.pubkey');
    }

    public function checkout(Order $order)
    {
        $orderProducts = $order->orderProducts()->with('product')->get();

        $basketOrder = [];

        foreach ($orderProducts as $orderProduct) {
            $basketOrder[] = [
                'name' => $orderProduct->product->name,
                'qty' => $orderProduct->count,
                'sum' => $orderProduct->product->price->getMinorAmount()->toInt(),
                'total' => $orderProduct->product->price->multipliedBy($orderProduct->count)->getMinorAmount()->toInt(),
                'unit' => 'шт.',
                'code' => $orderProduct->product->article,
            ];
        }

        $responseData = $this->makeRequest('/merchant/invoice/create', 'post', [
            'amount' => $order->total->getMinorAmount()->toInt(),
            'ccy' => 980,
            'redirectUrl' => route('payments.monobank.check', $order->id),
            'webHookUrl' => route('payments.monobank.webhook', $order->id),
            'merchantPaymInfo' => [
                'destination' => 'Замовлення товарів на сайті Dressiety',
                'comment' => 'Замовлення товарів на сайті Dressiety',
                'basketOrder' => $basketOrder,
            ],
        ]);

        $invoiceId = $responseData['invoiceId'];

        $order->update([
            'transaction_id' => $invoiceId
        ]);

        return $responseData['pageUrl'];
    }

    public function check(Order $order)
    {
        $responseData = $this->makeRequest('/merchant/invoice/status', 'get', [
            'invoiceId' => $order->transaction_id
        ]);

        $this->updateStatus($order, $responseData);

        return $order;
    }

    public function webhook(Request $request, Order $order)
    {
        Log::debug('Monobank webhook starting method...');

        if (!$this->verify($request)) {
            return $order;
        }

        Log::debug('Monobank webhook verified');

        $requestData = $request->all();

        $this->updateStatus($order, $requestData);

        return $order;
    }

    private function updateStatus($order, $data)
    {
        $modifiedAt = Carbon::parse($data['modifiedDate']);

        if (!$order->transaction_modified_at || $modifiedAt->greaterThan($order->transaction_modified_at)) {
            $status = $data['status'];
    
            $oldStatus = $order->payment_status;
    
            $newStatus = $this->parseStatus($status);
    
            if ($newStatus != $oldStatus) {
                $order->update([
                    'payment_status' => $newStatus,
                    'transaction_modified_at' => $modifiedAt,
                ]);
            }
        }
    }

    private function makeRequest($endpoint, $method, $data): array
    {
        $response = $this->prepareRequest()->{$method}($this->url($endpoint), $data);

        return $this->prepareResponse($response);
    }

    private function url($endpoint): string
    {
        return $this->domain.$endpoint;
    }

    private function prepareRequest(): PendingRequest
    {
        return Http::withHeaders(['X-Token' => $this->token]);
    }

    private function prepareResponse($response): array
    {
        if (!$response->successful()) {
            throw new Exception(implode(' ', $response->json()));
        }

        return $response->json();
    }

    private function parseStatus(string $status): PaymentStatusEnum
    {
        switch($status) {
            case 'created':
                return PaymentStatusEnum::CREATED;
            case 'processing':
                return PaymentStatusEnum::PROCESS;
            case 'success':
                return PaymentStatusEnum::SUCCESS;
            case 'reversed':
                return PaymentStatusEnum::SUCCESS;
            case 'hold':
                return PaymentStatusEnum::FAILED;
            case 'failure':
                return PaymentStatusEnum::FAILED;
            case 'expired':
                return PaymentStatusEnum::FAILED;
            default:
                return PaymentStatusEnum::CREATED;
        }
    }

    private function verify(Request $request)
    {
        $pubKeyBase64 = $this->pubkey;

        $xSignBase64 = $request->header('x-sign');

        $message = json_encode($request->all(), JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);

        $signature = base64_decode($xSignBase64);
        $publicKey = openssl_get_publickey(base64_decode($pubKeyBase64));

        $result = openssl_verify($message, $signature, $publicKey, OPENSSL_ALGO_SHA256);

        return $result;
    }
}