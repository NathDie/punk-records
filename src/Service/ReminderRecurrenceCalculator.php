<?php

namespace App\Service;

use App\Entity\Reminder;
use App\Enum\RecurrenceRule;
use DateTimeImmutable;

final class ReminderRecurrenceCalculator extends AbstractRecurrenceCalculator
{
    public function calculateNextDate(Reminder $reminder): ?DateTimeImmutable
    {
        $remindAt = $reminder->getRemindAt();

        if ($remindAt === null) {
            throw new \InvalidArgumentException(
                'Cannot calculate the next date without a reminder date.'
            );
        }

        return match ($reminder->getRecurring()) {
            RecurrenceRule::NONE => null,
            RecurrenceRule::WEEKLY => $remindAt->modify('+1 week'),
            RecurrenceRule::MONTHLY => $this->addMonths($remindAt, 1),
            RecurrenceRule::QUARTERLY => $this->addMonths($remindAt, 3),
            RecurrenceRule::YEARLY => $this->addYears($remindAt),
        };
    }
}
