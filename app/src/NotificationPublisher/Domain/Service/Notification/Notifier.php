<?php

declare(strict_types=1);

namespace App\NotificationPublisher\Domain\Service\Notification;

use App\NotificationPublisher\Domain\DTO\NotificationDTO;
use App\NotificationPublisher\Domain\Exception\WrongNotificationChannelException;
use App\NotificationPublisher\Domain\Service\Notification\Channel\ChannelInterface;

final readonly class Notifier
{
    public function __construct(
        /** @var iterable<ChannelInterface> */
        private iterable $notificationChannels,
        private array $channelsConfig,
    ) {
    }

    public function publish(NotificationDTO $notificationDTO): void
    {
        $channelEnum = $notificationDTO->notificationChannel;

        foreach ($this->notificationChannels as $channel) {
            if (true === $this->channelsConfig[$channelEnum->value] && true === $channel->support($channelEnum)) {
                $channel->send($notificationDTO->payload);

                return;
            }
        }

        throw new WrongNotificationChannelException($channelEnum->value);
    }
}
