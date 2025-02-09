<?php

namespace App\Enums;

enum ContactEnum : string
{
    case PHONE = 'phone';
    case EMAIL = 'email';
    case ADDRESS = 'address';
}