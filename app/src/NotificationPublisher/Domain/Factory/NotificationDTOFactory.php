<?php

declare(strict_types=1);

namespace App\NotificationPublisher\Domain\Factory;

use App\NotificationPublisher\Domain\DTO\EmailPayloadDTO;
use App\NotificationPublisher\Domain\DTO\NotificationDTO;
use App\NotificationPublisher\Domain\DTO\SMSPayloadDTO;
use App\NotificationPublisher\Domain\Enum\NotificationChannel;
use App\NotificationPublisher\Domain\Exception\WrongNotificationChannelException;
use App\Shared\Serializer\SerializerInterface;

final readonly class NotificationDTOFactory
{
    public function __construct(
        private SerializerInterface $serializer,
    ) {
    }

    /** @param array<string> $payload */
    public function create(string $channel, array $payload): NotificationDTO
    {
        $notificationChannel = NotificationChannel::tryFrom($channel = strtolower($channel));

        if (null === $notificationChannel) {
            throw new WrongNotificationChannelException($channel);
        }

        $type = match ($notificationChannel) {
            NotificationChannel::SMS => SMSPayloadDTO::class,
            NotificationChannel::EMAIL => EmailPayloadDTO::class,
        };

        return new NotificationDTO(
            $this->serializer->deserialize(json_encode($payload), $type),
            NotificationChannel::from($channel),
        );
    }
}