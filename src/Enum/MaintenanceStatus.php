<?php

namespace App\Enum;

enum MaintenanceStatus: string
{
    case UP_TO_DATE = 'up_to_date';
    case TODO = 'todo';
    case OVERDUE = 'overdue';

    public function label(): string
    {
        return match ($this) {
            self::UP_TO_DATE => 'À jour',
            self::TODO => 'À faire',
            self::OVERDUE => 'En retard',
        };
    }
}
