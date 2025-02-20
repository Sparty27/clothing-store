<?php

namespace App\Enums;

enum SortProduct: string
{
    case PRICE_ASC = 'price_asc';
    case PRICE_DESC = 'price_desc';
    case NAME_ASC = 'name_asc';
    case NAME_DESC = 'name_desc';

    public function label()
    {
        return trans('enums.sort_products.'.$this->value);
    }
}