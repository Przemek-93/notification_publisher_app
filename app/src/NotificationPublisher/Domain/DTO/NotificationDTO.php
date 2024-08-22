<?php

declare(strict_types=1);

namespace App\NotificationPublisher\Domain\DTO;

use App\NotificationPublisher\Domain\Enum\NotificationChannel;

final readonly class NotificationDTO
{
    public function __construct(
        public PayloadInterface $payload,
        public NotificationChannel $notificationChannel = NotificationChannel::EMAIL,
    ) {
    }
}