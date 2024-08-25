<?php

declare(strict_types=1);

namespace App\NotificationPublisher\Domain\DTO;

final readonly class RecipientDTO
{
    public function __construct(
        public string $id,
        public string $email,
        public string $firstName,
        public string $lastName,
        public string $phone,
    ) {
    }

    public function getName(): string
    {
        return $this->firstName.' '.$this->lastName;
    }
}
