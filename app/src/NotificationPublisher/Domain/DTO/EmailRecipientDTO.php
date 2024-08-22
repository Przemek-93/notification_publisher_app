<?php

declare(strict_types=1);

namespace App\NotificationPublisher\Domain\DTO;

final readonly class EmailRecipientDTO implements PayloadInterface
{
    public function __construct(
        public string $email,
        public string $name,
    ) {
    }
}
