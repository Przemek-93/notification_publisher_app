<?php

declare(strict_types=1);

namespace App\NotificationPublisher\Application\CQRS\Command;

use App\Shared\CQRS\CommandInterface;

final readonly class SendNotification implements CommandInterface
{
    /**
     * @param array<string> $channels
     * @param array<string, mixed> $payload
     * @param array<array<string, mixed>> $recipients
     */
    public function __construct(
        public array $channels,
        public array $payload,
        public array $recipients,
    ) {
    }
}
