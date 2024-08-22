<?php

declare(strict_types=1);

namespace App\NotificationPublisher\Domain\Enum;

enum NotificationChannel: string
{
    case EMAIL = 'email';

    case SMS = 'sms';
}
