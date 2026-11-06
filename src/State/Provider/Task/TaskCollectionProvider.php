<?php

namespace App\State\Provider\Task;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProviderInterface;
use App\Entity\Task;
use App\Repository\TaskRepository;

/**
 * @implements ProviderInterface<Task>
 */
final readonly class TaskCollectionProvider implements ProviderInterface
{
    public function __construct(
        private TaskRepository $repository,
    ) {
    }

    public function provide(Operation $operation, array $uriVariables = [], array $context = []): array
    {
        return $this->repository->findUpcoming();
    }
}
