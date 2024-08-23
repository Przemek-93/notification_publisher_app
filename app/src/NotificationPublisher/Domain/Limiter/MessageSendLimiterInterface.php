<?php

declare(strict_types=1);

namespace App\NotificationPublisher\Domain\Limiter;

interface MessageSendLimiterInterface
{
    public function isSendLimitNotExceed(?string $key = 'send_message'): bool;

    public function getRetryAfterMinutes(?string $key = 'send_message'): float;
}
