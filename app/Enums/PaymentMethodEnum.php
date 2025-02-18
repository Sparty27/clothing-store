<?php

namespace App\Enums;

enum PaymentMethodEnum : string
{
    case MONOBANK = 'monobank';
    case ON_RECEIPT = 'on_receipt';
    case BANK_TRANSFER = 'bank_transfer';

    public function label()
    {
        return trans('enums.payment_methods.'.$this->value);
    }
}