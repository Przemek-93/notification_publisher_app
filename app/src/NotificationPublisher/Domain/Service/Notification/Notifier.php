<?php

declare(strict_types=1);

namespace App\NotificationPublisher\Domain\Service\Notification;

use App\NotificationPublisher\Domain\DTO\NotificationDTO;
use App\NotificationPublisher\Domain\Exception\MessageSendLimitExceed;
use App\NotificationPublisher\Domain\Limiter\MessageSendLimiterInterface;
use App\NotificationPublisher\Domain\Notifier\NotifierInterface;

final readonly class Notifier
{
    public function __construct(
        private int $notificationSendLimit,
        private MessageSendLimiterInterface $messageSendLimiter,
        private NotifierInterface $notifier,
    ) {
    }

    public function publish(NotificationDTO $notificationDTO): void
    {
        $payload = $notificationDTO->payload;
        foreach ($notificationDTO->recipients as $recipient) {
            $this->checkSendLimit($recipient->id);

            $this->notifier->send(
                $payload->subject,
                $payload->content,
                $notificationDTO->enabledChannels,
                $recipient->email,
                $recipient->phone,
            );
        }
    }

    private function checkSendLimit(string $recipientId): void
    {
        $limiterKey = 'user_'.$recipientId;

        if (true === $this->messageSendLimiter->isSendLimitNotExceed($limiterKey)) {
            return;
        }

        throw new MessageSendLimitExceed(
            $this->notificationSendLimit,
            $this->messageSendLimiter->getRetryAfterMinutes($limiterKey),
        );
    }
}
