<?php

declare(strict_types=1);

namespace App\NotificationPublisher\Domain\Sender;

interface MailerInterface
{
    public function send(
        string $toEmail,
        string $toName,
        string $subject,
        string $text,
        string $html,
    ): void;
}
