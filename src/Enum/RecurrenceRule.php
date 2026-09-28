<?php

namespace App\Enum;

enum RecurrenceRule: string
{
    case NONE = 'none';
    case WEEKLY = 'weekly';
    case MONTHLY = 'monthly';
    case QUARTERLY = 'quarterly';
    case YEARLY = 'yearly';
}
