<?php

namespace App\Enums;

enum OrderStatusEnum: string
{
    case NEW = 'new';
    case PROCESS = 'in_process';
    case DONE = 'done';
    case FAILED = 'failed';

    public function label()
    {
        return trans('enums.order_status.'.$this->value);
    }

    //Перевірка чи потрібно товар переносити на склад
    public static function isNeededStoreProducts($beforeStatus, $currentStatus)
    {
        if ($beforeStatus !== OrderStatusEnum::FAILED && $currentStatus === OrderStatusEnum::FAILED) {
            return true;
        }

        return false;
    }

    //Перевірка чи потрібно брати товари зі складу
    public static function isNeededGetProducts($beforeStatus, $currentStatus)
    {
        if ($beforeStatus === OrderStatusEnum::FAILED && $currentStatus !== OrderStatusEnum::FAILED) {
            return true;
        }

        return false;
    }

    public function colorTailwind()
    {
        switch ($this->value) {
            case 'new':
                return "pastelOrange";
            case 'in_process':
                return "pastelBlue";
            case 'done':
                return "pastelGreen";
            case 'failed':
                return "pastelRed";
        }
    }
}
