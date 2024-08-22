<?php

declare(strict_types=1);

namespace App\NotificationPublisher\Infrastructure\Sender\Email;

use App\NotificationPublisher\Domain\DTO\EmailPayloadDTO;
use App\NotificationPublisher\Domain\Sender\MailerInterface;
use Mailtrap\MailtrapClient;
use Mailtrap\Mime\MailtrapEmail;
use Symfony\Component\Mime\Address;
use Symfony\Component\Mime\Email;

final readonly class MailTrap implements MailerInterface
{
    public function __construct(
        private string $apiKey,
    ) {
    }

    public function send(EmailPayloadDTO $emailPayloadDTO): void
    {
        $recipients = array_map(
            static fn (array $recipient) => new Address($recipient['email'], $recipient['name']),
            $emailPayloadDTO->recipients,
        );

        $email = (new MailtrapEmail())
            ->from(new Address($emailPayloadDTO->fromEmail, $emailPayloadDTO->fromName))
            ->to(...$recipients)
            ->priority(Email::PRIORITY_HIGH)
            ->subject($emailPayloadDTO->subject)
            ->text($emailPayloadDTO->text)
            ->html($emailPayloadDTO->html);

        MailtrapClient::initSendingEmails($this->apiKey)->send($email);
    }
}