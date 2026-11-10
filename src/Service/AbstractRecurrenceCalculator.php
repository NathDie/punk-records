<?php

namespace App\Service;

use DateTimeImmutable;

abstract class AbstractRecurrenceCalculator
{
    protected function addMonths(
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

    protected function addYears(
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
