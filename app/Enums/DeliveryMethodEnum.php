<?php

namespace App\Enums;

enum DeliveryMethodEnum : string
{
    case NOVAPOSHTA = 'nova_poshta';
    case PICKUP = 'pickup';

    public function label()
    {
        return trans('enums.delivery_methods.'.$this->value);
    }
}