<?php

declare(strict_types=1);

namespace App\NotificationPublisher\Domain\Sender;

use App\NotificationPublisher\Domain\DTO\EmailPayloadDTO;

interface MailerInterface
{
    public function send(EmailPayloadDTO $emailPayloadDTO): void;
}
