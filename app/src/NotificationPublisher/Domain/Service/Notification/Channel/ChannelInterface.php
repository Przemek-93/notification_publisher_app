<?php

declare(strict_types=1);

namespace App\NotificationPublisher\Domain\Service\Notification\Channel;

use App\NotificationPublisher\Domain\DTO\PayloadDTO;
use App\NotificationPublisher\Domain\DTO\RecipientDTO;
use App\NotificationPublisher\Domain\Enum\NotificationChannel;

interface ChannelInterface
{
    public function support(NotificationChannel $notificationChannel): bool;

    public function send(PayloadDTO $payloadDTO, RecipientDTO $recipientDTO): void;
}
