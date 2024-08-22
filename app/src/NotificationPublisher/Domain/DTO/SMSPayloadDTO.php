<?php

declare(strict_types=1);

namespace App\NotificationPublisher\Domain\DTO;

final readonly class SMSPayloadDTO implements PayloadInterface
{
    public function __construct(
        public string $recipientNumber,
        public string $messageBody,
    ) {
    }
}
