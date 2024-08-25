<?php

declare(strict_types=1);

namespace App\NotificationPublisher\Domain\Service\Notification\Channel;

use App\NotificationPublisher\Domain\DTO\EmailPayloadDTO;
use App\NotificationPublisher\Domain\DTO\PayloadDTO;
use App\NotificationPublisher\Domain\DTO\RecipientDTO;
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

    public function send(PayloadDTO $payloadDTO, RecipientDTO $recipientDTO): void
    {
        $payload = $payloadDTO->emailPayloadDTO;
        if (false === $payload instanceof EmailPayloadDTO) {
            throw new WrongNotificationPayloadException($payload::class);
        }

        foreach ($this->mailerSenders as $sender) {
            try {
                $sender->send(
                    $recipientDTO->email,
                    $recipientDTO->getName(),
                    $payload->subject,
                    $payload->text,
                    $payload->html,
                );

                return;
            } catch (Throwable $throwable) {
                $this->logger->error($throwable->getMessage());
            }
        }
    }
}
