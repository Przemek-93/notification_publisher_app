<?php

declare(strict_types=1);

namespace App\NotificationPublisher\Application\CQRS\Command;

use App\Shared\CQRS\CommandInterface;

final readonly class SendNotification implements CommandInterface
{
    /** @param array<string, mixed> $payload */
    public function __construct(
        public string $channel,
        public array $payload
    ) {
    }
}
