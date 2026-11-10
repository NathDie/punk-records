<?php

namespace App\Service;

use App\Entity\Maintenance;
use App\Enum\RecurrenceRule;
use DateTimeImmutable;

final class MaintenanceRecurrenceCalculator extends AbstractRecurrenceCalculator
{
    public function calculateNextDate(Maintenance $maintenance, DateTimeImmutable $doneAt): ?DateTimeImmutable
    {
        return match ($maintenance->getFrequency()) {
            RecurrenceRule::NONE => null,
            RecurrenceRule::WEEKLY => $doneAt->modify('+1 week'),
            RecurrenceRule::MONTHLY => $this->addMonths($doneAt, 1),
            RecurrenceRule::QUARTERLY => $this->addMonths($doneAt, 3),
            RecurrenceRule::YEARLY => $this->addYears($doneAt),
        };
    }
}
