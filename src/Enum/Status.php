<?php

namespace App\Enum;

enum Status: string
{
    case TODO = 'todo';
    case IN_PROGRESS = 'in_progress';
    case PENDING = 'pending';
    case DONE = 'done';
    case SNOOZED = 'snoozed';
    case UPCOMING = 'upcoming';
    case OVERDUE = 'overdue';
}
