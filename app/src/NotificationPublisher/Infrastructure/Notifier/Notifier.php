<?php

declare(strict_types=1);

namespace App\NotificationPublisher\Infrastructure\Notifier;

use App\NotificationPublisher\Domain\Notifier\NotifierInterface;
use Symfony\Component\Notifier\Notification\Notification;
use Symfony\Component\Notifier\NotifierInterface as SymfonyNotifierInterface;
use Symfony\Component\Notifier\Recipient\Recipient;

final readonly class Notifier implements NotifierInterface
{
    public function __construct(
        private SymfonyNotifierInterface $notifier,
    ) {
    }

    public function send(
        string $subject,
        string $content,
        array $channels,
        string $email,
        string $phone,
    ): void {
        $notification = (new Notification())
            ->subject($subject)
            ->content($content)
            ->channels($channels);

        $this->notifier->send(
            $notification,
            new Recipient($email, $phone),
        );
    }
}
