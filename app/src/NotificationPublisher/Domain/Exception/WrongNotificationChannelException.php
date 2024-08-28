<?php

declare(strict_types=1);

namespace App\NotificationPublisher\Domain\Exception;

use Exception;

class WrongNotificationChannelException extends Exception
{
    public const string MESSAGE = 'Notification channel not exists or is disabled. Please check in env if is enabled.';

    public function __construct()
    {
        parent::__construct(self::MESSAGE);
    }
}
