<?php

namespace App\State\Processor\Maintenance;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProcessorInterface;
use App\Entity\MaintenanceLog;
use App\Service\MaintenanceRecurrenceCalculator;
use Symfony\Component\DependencyInjection\Attribute\Autowire;

/**
 * @implements ProcessorInterface<MaintenanceLog, MaintenanceLog>
 */
final readonly class MaintenanceLogProcessor implements ProcessorInterface
{
    public function __construct(
        #[Autowire(service: 'api_platform.doctrine.orm.state.persist_processor')]
        private ProcessorInterface $persistProcessor,
        private MaintenanceRecurrenceCalculator $maintenanceRecurrenceCalculator
    ) {
    }

    public function process(
        mixed $data,
        Operation $operation,
        array $uriVariables = [],
        array $context = []
    ): mixed {
        if (!$data instanceof MaintenanceLog) {
            return $this->persistProcessor->process($data, $operation, $uriVariables, $context);
        }

        $maintenance = $data->getMaintenance();

        if (
            $maintenance !== null
            && (
                $maintenance->getLastDoneAt() === null
                || $data->getDoneAt() > $maintenance->getLastDoneAt()
            )
        ) {
            $maintenance->setLastDoneAt($data->getDoneAt());
            $maintenance->setNextDueAt($this->maintenanceRecurrenceCalculator->calculateNextDate($maintenance, $data->getDoneAt()));
        }

        return $this->persistProcessor->process($data, $operation, $uriVariables, $context);
    }
}
