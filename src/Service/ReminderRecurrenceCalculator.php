<?php

namespace App\Service;

use App\Entity\Reminder;
use App\Enum\RecurrenceRule;
use DateTimeImmutable;

final class ReminderRecurrenceCalculator
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

    private function addMonths(
        DateTimeImmutable $date,
        int $months,
    ): DateTimeImmutable {
        $day = (int) $date->format('d');

        $target = $date
            ->modify('first day of this month')
            ->modify(sprintf('+%d months', $months));

        $lastDay = (int) $target->format('t');

        return $target->setDate(
            (int) $target->format('Y'),
            (int) $target->format('m'),
            min($day, $lastDay),
        );
    }

    private function addYears(
        DateTimeImmutable $date,
    ): DateTimeImmutable {
        $month = (int) $date->format('m');
        $day = (int) $date->format('d');

        $year = (int) $date->format('Y') + 1;

        $target = $date->setDate($year, $month, 1);
        $lastDay = (int) $target->format('t');

        return $target->setDate(
            $year,
            $month,
            min($day, $lastDay),
        );
    }
}
