<?php

namespace App\Enum;

enum EquipmentStatus: string
{
    case AVAILABLE = 'available';
    case IN_USE = 'in_use';
    case BROKEN = 'broken';
    case LOST = 'lost';
}
