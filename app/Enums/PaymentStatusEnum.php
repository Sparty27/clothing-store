<?php

namespace App\Enums;

enum PaymentStatusEnum : string
{
    case CREATED = 'created';
    case PROCESS = 'in_process';
    case SUCCESS = 'success';
    case FAILED = 'failed';

    public function label()
    {
        return trans('enums.payment_status.'.$this->value);
    }

    public function colorTailwind()
    {
        switch ($this->value) {
            case 'created':
                return "pastelOrange";
            case 'in_process':
                return "pastelBlue";
            case 'success':
                return "pastelGreen";
            case 'failed':
                return "pastelRed";
        }
    }
}