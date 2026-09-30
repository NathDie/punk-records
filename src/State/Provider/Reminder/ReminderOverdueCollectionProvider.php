<?php

namespace App\State\Provider\Reminder;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProviderInterface;
use App\Entity\Reminder;
use App\Repository\ReminderRepository;

/**
 * @implements ProviderInterface<Reminder>
 */
final readonly class ReminderOverdueCollectionProvider implements ProviderInterface
{
    public function __construct(
        private ReminderRepository $repository,
    ) {
    }

    public function provide(Operation $operation, array $uriVariables = [], array $context = []): array
    {
        return $this->repository->findOverdue();
    }
}
