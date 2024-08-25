<?php

declare(strict_types=1);

namespace App\NotificationPublisher\Domain\Factory;

use App\NotificationPublisher\Domain\DTO\EmailPayloadDTO;
use App\NotificationPublisher\Domain\DTO\NotificationDTO;
use App\NotificationPublisher\Domain\DTO\PayloadDTO;
use App\NotificationPublisher\Domain\DTO\RecipientDTO;
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

    /** @param array<array-key, mixed> $payload */
    public function create(string $channel, array $payload, bool $sendVialAllChannels = false): NotificationDTO
    {
        $notificationChannel = NotificationChannel::tryFrom($channel = strtolower($channel));

        if (null === $notificationChannel) {
            throw new WrongNotificationChannelException($channel);
        }

        $recipients = [];
        foreach ($payload['recipients'] as $recipient) {
            $recipients[] = $this->serializer->deserialize(json_encode($recipient), RecipientDTO::class);
        }

        $payload = new PayloadDTO(
            $recipients,
            $this->serializer->deserialize(json_encode($payload['email']), EmailPayloadDTO::class),
            $this->serializer->deserialize(json_encode($payload['sms']), SMSPayloadDTO::class),
        );

        return new NotificationDTO(
            $payload,
            $notificationChannel,
            $sendVialAllChannels,
        );
    }
}
