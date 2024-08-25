<?php

declare(strict_types=1);

namespace App\NotificationPublisher\Domain\Service\Notification\Channel;

use App\NotificationPublisher\Domain\DTO\PayloadDTO;
use App\NotificationPublisher\Domain\DTO\RecipientDTO;
use App\NotificationPublisher\Domain\DTO\SMSPayloadDTO;
use App\NotificationPublisher\Domain\Enum\NotificationChannel;
use App\NotificationPublisher\Domain\Exception\WrongNotificationPayloadException;
use App\NotificationPublisher\Domain\Sender\SMSInterface;
use Psr\Log\LoggerInterface;
use Throwable;

final readonly class SMSChannel implements ChannelInterface
{
    public function __construct(
        private SMSInterface $sms,
        private LoggerInterface $logger,
    ) {
    }

    public function support(NotificationChannel $notificationChannel): bool
    {
        return NotificationChannel::SMS === $notificationChannel;
    }

    public function send(PayloadDTO $payloadDTO, RecipientDTO $recipientDTO): void
    {
        $payload = $payloadDTO->smsPayloadDTO;

        if (false === $payload instanceof SMSPayloadDTO) {
            throw new WrongNotificationPayloadException($payload::class);
        }

        try {
            $this->sms->send(
                $payload->messageBody,
                $recipientDTO->phone,
            );

            return;
        } catch (Throwable $throwable) {
            $this->logger->error($throwable->getMessage());
        }
    }
}
