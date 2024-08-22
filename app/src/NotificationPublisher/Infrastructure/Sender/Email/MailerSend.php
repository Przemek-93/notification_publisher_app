<?php

declare(strict_types=1);

namespace App\NotificationPublisher\Infrastructure\Sender\Email;

use App\NotificationPublisher\Domain\DTO\EmailPayloadDTO;
use App\NotificationPublisher\Domain\Sender\MailerInterface;
use MailerSend\Helpers\Builder\EmailParams;
use MailerSend\Helpers\Builder\Recipient;
use MailerSend\MailerSend as MailerSendClient;

final readonly class MailerSend implements MailerInterface
{
    public function __construct(
        private string $apiKey,
    ) {
    }

    public function send(EmailPayloadDTO $emailPayloadDTO): void
    {
        $mailerSend = new MailerSendClient(['api_key' => $this->apiKey]);

        $recipients = array_map(
            static fn (string $recipient) => new Recipient($recipient, 'Recipient'),
            $emailPayloadDTO->recipients,
        );

        $emailParams = (new EmailParams())
            ->setFrom($emailPayloadDTO->fromEmail)
            ->setFromName($emailPayloadDTO->fromName)
            ->setRecipients($recipients)
            ->setSubject($emailPayloadDTO->subject)
            ->setHtml($emailPayloadDTO->html)
            ->setText($emailPayloadDTO->text);

        $mailerSend->email->send($emailParams);
    }
}