<?php

declare(strict_types=1);

namespace App\NotificationPublisher\Infrastructure\Sender\Email;

use App\NotificationPublisher\Domain\Sender\MailerInterface;
use MailerSend\Helpers\Builder\EmailParams;
use MailerSend\Helpers\Builder\Recipient;
use MailerSend\MailerSend as MailerSendClient;

final readonly class MailerSend implements MailerInterface
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
        $mailerSend = new MailerSendClient(['api_key' => $this->apiKey]);

        $emailParams = (new EmailParams())
            ->setFrom($this->fromEmail)
            ->setFromName($this->fromName)
            ->setRecipients([new Recipient($toEmail, $toName)])
            ->setSubject($subject)
            ->setHtml($html)
            ->setText($text);

        $mailerSend->email->send($emailParams);
    }
}
