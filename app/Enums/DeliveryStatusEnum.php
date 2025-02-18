<?php

namespace App\Enums;

enum DeliveryStatusEnum : string
{
    case CREATED = 'created';
    case PROCESS = 'in_process';
    case DELIVERIED = 'deliveried';
    case CANCELED = 'canceled';
    case RETURNED = 'returned';

    public function label()
    {
        return trans('enums.delivery_status.'.$this->value);
    }

    public function colorTailwind()
    {
        switch ($this->value) {
            case 'created':
                return "pastelOrange";
            case 'in_process':
                return "pastelBlue";
            case 'deliveried':
                return "pastelGreen";
            case 'canceled':
                return "pastelRed";
            case 'returned':
                return "pastelRed";
        }
    }
}