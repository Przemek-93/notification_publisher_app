<?php

declare(strict_types=1);

namespace App\NotificationPublisher\Domain\DTO;

final readonly class SMSPayloadDTO
{
    public function __construct(
        public ?string $messageBody = null,
    ) {
    }
}
