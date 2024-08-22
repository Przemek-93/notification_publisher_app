<?php

declare(strict_types=1);

namespace App\NotificationPublisher\Application\CQRS\Command;

use App\NotificationPublisher\Domain\Factory\NotificationDTOFactory;
use App\NotificationPublisher\Domain\Service\Notification\Notifier;
use App\Shared\CQRS\CommandHandlerInterface;

final readonly class SendNotificationHandler implements CommandHandlerInterface
{
    public function __construct(
        private Notifier $notifier,
        private NotificationDTOFactory $factory,
    ) {
    }

    public function __invoke(SendNotification $command): void
    {
        $this->notifier->publish(
            $this->factory->create(
                $command->channel,
                $command->payload,
            )
        );
    }
}