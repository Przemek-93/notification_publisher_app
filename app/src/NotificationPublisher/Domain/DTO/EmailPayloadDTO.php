<?php

declare(strict_types=1);

namespace App\NotificationPublisher\Domain\DTO;

final readonly class EmailPayloadDTO implements PayloadInterface
{
    /** @param array<EmailRecipientDTO> $recipients */
    public function __construct(
        public string $fromEmail,
        public string $fromName,
        public string $subject,
        public string $text,
        public string $html,
        public array $recipients = [],
    ) {
    }
}