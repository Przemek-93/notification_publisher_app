<?php

declare(strict_types=1);

namespace App\NotificationPublisher\Domain\Service\Notification;

use App\NotificationPublisher\Domain\DTO\NotificationDTO;
use App\NotificationPublisher\Domain\Enum\NotificationChannel;
use App\NotificationPublisher\Domain\Exception\MessageSendLimitExceed;
use App\NotificationPublisher\Domain\Exception\WrongNotificationChannelException;
use App\NotificationPublisher\Domain\Limiter\MessageSendLimiterInterface;
use App\NotificationPublisher\Domain\Service\Notification\Channel\ChannelInterface;

final readonly class Notifier
{
    public function __construct(
        /** @var iterable<ChannelInterface> */
        private iterable $notificationChannels,
        private array $channelsConfig,
        private int $notificationSendLimit,
        private MessageSendLimiterInterface $messageSendLimiter,
    ) {
    }

    public function publish(NotificationDTO $notificationDTO): void
    {
        $channelEnum = $notificationDTO->notificationChannel;
        $payload = $notificationDTO->payload;

        $supported = false;
        foreach ($this->notificationChannels as $channel) {
            if ($this->checkAbilityToSend($notificationDTO->sendViaAllChannels, $channelEnum, $channel)) {
                $supported = true;
                foreach ($payload->recipients as $recipient) {
                    $this->checkSendLimit($recipient->id);
                    $channel->send($payload, $recipient);
                }
            }
        }

        if (false === $supported) {
            throw new WrongNotificationChannelException($channelEnum->value);
        }
    }

    private function checkAbilityToSend(
        bool $sendViaAllChannels,
        NotificationChannel $channelEnum,
        ChannelInterface $channel
    ): bool {
        return true === $sendViaAllChannels
               || (true === $this->channelsConfig[$channelEnum->value] && true === $channel->support($channelEnum));
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
