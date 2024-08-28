<?php

declare(strict_types=1);

namespace App\NotificationPublisher\Domain\Notifier;

interface NotifierInterface
{
    public function send(
        string $subject,
        string $content,
        array $channels,
        string $email,
        string $phone,
    ): void;
}
