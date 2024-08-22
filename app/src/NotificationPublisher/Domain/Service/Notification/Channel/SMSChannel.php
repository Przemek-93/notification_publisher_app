<?php

declare(strict_types=1);

namespace App\NotificationPublisher\Domain\Service\Notification\Channel;

use App\NotificationPublisher\Domain\DTO\PayloadInterface;
use App\NotificationPublisher\Domain\DTO\SMSPayloadDTO;
use App\NotificationPublisher\Domain\Enum\NotificationChannel;
use App\NotificationPublisher\Domain\Exception\WrongNotificationPayloadException;
use App\NotificationPublisher\Domain\Sender\SMSInterface;

final readonly class SMSChannel implements ChannelInterface
{
    public function __construct(
        private SMSInterface $sms,
    ) {
    }

    public function support(NotificationChannel $notificationChannel): bool
    {
        return NotificationChannel::SMS === $notificationChannel;
    }

    public function send(PayloadInterface $payload): void
    {
        if (true === $payload instanceof SMSPayloadDTO) {
            $this->sms->send($payload);

            return;
        }

        throw new WrongNotificationPayloadException($payload::class);
    }
}
