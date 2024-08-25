<?php

declare(strict_types=1);

namespace App\NotificationPublisher\Domain\DTO;

final readonly class PayloadDTO
{
    /** @param array<RecipientDTO> $recipients */
    public function __construct(
        public array $recipients,
        public ?EmailPayloadDTO $emailPayloadDTO = null,
        public ?SMSPayloadDTO $smsPayloadDTO = null,
    ) {
    }
}
