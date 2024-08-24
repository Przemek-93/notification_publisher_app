<?php

declare(strict_types=1);

namespace App\NotificationPublisher\Infrastructure\Sender\Email;

use App\NotificationPublisher\Domain\Sender\MailerInterface;
use Mailtrap\MailtrapClient;
use Mailtrap\Mime\MailtrapEmail;
use Symfony\Component\Mime\Address;
use Symfony\Component\Mime\Email;

final readonly class MailTrap implements MailerInterface
{
    public function __construct(
        private string $apiKey,
        private string $fromEmail,
        private string $fromName,
    ) {
    }

    public function send(
        string $toEmail,
        string $toName,
        string $subject,
        string $text,
        string $html,
    ): void {
        $email = (new MailtrapEmail())
            ->from(new Address($this->fromEmail, $this->fromName))
            ->to(new Address($toEmail, $toName))
            ->priority(Email::PRIORITY_HIGH)
            ->subject($subject)
            ->text($text)
            ->html($html);

        MailtrapClient::initSendingEmails($this->apiKey)->send($email);
    }
}
