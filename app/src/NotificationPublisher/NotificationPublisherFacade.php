<?php

declare(strict_types=1);

namespace App\NotificationPublisher;

use App\NotificationPublisher\Application\CQRS\Command\SendNotification;
use App\Shared\CQRS\CommandBusInterface;
use App\Shared\Serializer\SerializerInterface;

final readonly class NotificationPublisherFacade
{
    public function __construct(
        private CommandBusInterface $commandBus,
        private SerializerInterface $serializer,
    ) {
    }

    public function notify(string $input): void
    {
        $this->commandBus->dispatch(
            $this->serializer->deserialize($input, SendNotification::class),
        );
    }
}
