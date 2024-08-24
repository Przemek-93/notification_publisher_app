<?php

declare(strict_types=1);

namespace App\NotificationPublisher\Domain\Sender;

interface SMSInterface
{
    public function send(
        string $messageBody,
        string $toNumber,
    ): void;
}
