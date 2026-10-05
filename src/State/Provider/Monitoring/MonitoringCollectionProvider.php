<?php

namespace App\State\Provider\Monitoring;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProviderInterface;
use App\Entity\Monitoring;
use App\Repository\MonitoringRepository;

/**
 * @implements ProviderInterface<Monitoring>
 */
final readonly class MonitoringCollectionProvider implements ProviderInterface
{
    public function __construct(
        private MonitoringRepository $repository,
    ) {
    }

    public function provide(Operation $operation, array $uriVariables = [], array $context = []): array
    {
        return $this->repository->findBy(['active' => true,]);
    }
}
