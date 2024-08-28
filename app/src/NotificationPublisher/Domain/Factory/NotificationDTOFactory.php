<?php

declare(strict_types=1);

namespace App\NotificationPublisher\Domain\Factory;

use App\NotificationPublisher\Domain\DTO\NotificationDTO;
use App\NotificationPublisher\Domain\DTO\PayloadDTO;
use App\NotificationPublisher\Domain\DTO\RecipientDTO;
use App\NotificationPublisher\Domain\Exception\CannotCreateNotificationDTOException;
use App\NotificationPublisher\Domain\Exception\WrongNotificationChannelException;
use App\Shared\Serializer\SerializerInterface;
use Throwable;

final readonly class NotificationDTOFactory
{
    public function __construct(
        private array $channelsConfig,
        private SerializerInterface $serializer,
    ) {
    }

    /**
     * @param array<string> $channels
     * @param array<array-key, mixed> $payload
     * @param array<array-key, mixed> $recipients
     */
    public function create(array $channels, array $payload, array $recipients): NotificationDTO
    {
        try {
            $payload = new PayloadDTO(
                $payload['subject'],
                $payload['content'],
            );

            $recipientsDTO = [];
            foreach ($recipients as $recipient) {
                $recipientsDTO[] = $this->serializer->deserialize(json_encode($recipient), RecipientDTO::class);
            }

            return new NotificationDTO(
                $payload,
                $this->getEnabledChannels($channels),
                $recipientsDTO,
            );
        } catch (Throwable $throwable) {
            throw new CannotCreateNotificationDTOException($throwable->getMessage(), $throwable);
        }
    }

    /** array<string> */
    private function getEnabledChannels(array $channels): array
    {
        $enabledChannels = array_filter(
            $this->channelsConfig,
            static fn (bool $enable) => true === $enable,
        );

        $channels = array_filter(
            $channels,
            static fn (string $channel) => array_key_exists($channel, $enabledChannels),
        );

        if ([] === $channels) {
            throw new WrongNotificationChannelException();
        }

        return array_values($channels);
    }
}
