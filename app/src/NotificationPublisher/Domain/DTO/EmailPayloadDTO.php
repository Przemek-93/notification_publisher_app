<?php

declare(strict_types=1);

namespace App\NotificationPublisher\Domain\DTO;

final readonly class EmailPayloadDTO
{
    public function __construct(
        public ?string $subject = null,
        public ?string $text = null,
        public ?string $html = null,
    ) {
    }
}
