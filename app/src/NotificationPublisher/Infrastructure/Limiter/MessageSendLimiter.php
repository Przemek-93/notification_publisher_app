<?php

declare(strict_types=1);

namespace App\NotificationPublisher\Infrastructure\Limiter;

use App\NotificationPublisher\Domain\Limiter\MessageSendLimiterInterface;
use Symfony\Component\RateLimiter\RateLimiterFactory;

final readonly class MessageSendLimiter implements MessageSendLimiterInterface
{
    public function __construct(
        private RateLimiterFactory $messageSendLimiter,
    ) {
    }

    public function isSendLimitNotExceed(?string $key = 'send_message'): bool
    {
        $limiter = $this->messageSendLimiter->create($key);

        return $limiter->consume()->isAccepted();
    }

    public function getRetryAfterMinutes(?string $key = 'send_message'): float
    {
        $limiter = $this->messageSendLimiter->create($key);

        return ceil(($limiter->consume(0)->getRetryAfter()->getTimestamp() - time()) / 60);
    }
}
