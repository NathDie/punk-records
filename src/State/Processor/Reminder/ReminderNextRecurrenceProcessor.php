<?php

namespace App\State\Processor\Reminder;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProcessorInterface;
use App\Repository\ReminderRepository;
use App\Service\ReminderRecurrenceCalculator;
use Doctrine\ORM\EntityManagerInterface;

/**
 * @implements ProcessorInterface<null, null>
 */
final readonly class ReminderNextRecurrenceProcessor implements ProcessorInterface
{
    public function __construct(
        private ReminderRepository           $reminderRepository,
        private ReminderRecurrenceCalculator $recurrenceCalculator,
        private EntityManagerInterface       $entityManager,
    ) {
    }

    public function process(mixed $data, Operation $operation, array $uriVariables = [], array $context = []): null
    {
        $reminders = $this->reminderRepository->findToday();

        foreach ($reminders as $reminder) {
            $nextDate = $this->recurrenceCalculator->calculateNextDate($reminder);

            if ($nextDate === null) {
                continue;
            }

            $reminder->setRemindAt($nextDate);
        }

        $this->entityManager->flush();

        return null;
    }
}
