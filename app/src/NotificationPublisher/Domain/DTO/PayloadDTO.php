<?php

declare(strict_types=1);

namespace App\NotificationPublisher\Domain\DTO;

final readonly class PayloadDTO
{
    public function __construct(
        public ?string $subject = null,
        public ?string $content = null,
    ) {
    }
}
