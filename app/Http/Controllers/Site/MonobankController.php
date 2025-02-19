<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Services\Payment\MonobankService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class MonobankController extends Controller
{
    public function check(Order $order, MonobankService $service)
    {
        try {
            $service->check($order);
        } catch(Exception $ex) {
            Log::error($ex->getMessage());
        } finally {
            return redirect()->route('orders.thank');
        }
    }

    public function webhook(Request $request, Order $order, MonobankService $service)
    {
        try {
            $service->webhook($request, $order);

            return response(status: 200, headers: ['x-sign' => $request->header('x-sign')]);
        } catch(Exception $ex) {
            Log::channel('daily')->error($ex->getMessage());

            return response(status: 200, headers: ['x-sign' => $request->header('x-sign')]);
        }
    }
}
