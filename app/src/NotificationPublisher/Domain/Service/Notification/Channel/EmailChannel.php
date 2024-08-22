<?php

declare(strict_types=1);

namespace App\NotificationPublisher\Domain\Service\Notification\Channel;

use App\NotificationPublisher\Domain\DTO\EmailPayloadDTO;
use App\NotificationPublisher\Domain\DTO\PayloadInterface;
use App\NotificationPublisher\Domain\Enum\NotificationChannel;
use App\NotificationPublisher\Domain\Exception\WrongNotificationPayloadException;
use App\NotificationPublisher\Domain\Sender\MailerInterface;
use Psr\Log\LoggerInterface;
use Throwable;

final readonly class EmailChannel implements ChannelInterface
{
    public function __construct(
        /** @var iterable<MailerInterface> */
        private iterable $mailerSenders,
        private LoggerInterface $logger,
    ) {
    }

    public function support(NotificationChannel $notificationChannel): bool
    {
        return NotificationChannel::EMAIL === $notificationChannel;
    }

    public function send(PayloadInterface $payload): void
    {
        if (false === $payload instanceof EmailPayloadDTO) {
            throw new WrongNotificationPayloadException($payload::class);
        }

        foreach ($this->mailerSenders as $sender) {
            try {
                $sender->send($payload);

                return;
            } catch (Throwable $throwable) {
                $this->logger->error($throwable->getMessage());
            }
        }
    }
}
