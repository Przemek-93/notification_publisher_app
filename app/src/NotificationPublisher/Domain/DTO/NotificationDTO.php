<?php

declare(strict_types=1);

namespace App\NotificationPublisher\Domain\DTO;

final readonly class NotificationDTO
{
    /** @param array<RecipientDTO> $recipients */
    public function __construct(
        public PayloadDTO $payload,
        public array $enabledChannels,
        public array $recipients,
    ) {
    }
}
