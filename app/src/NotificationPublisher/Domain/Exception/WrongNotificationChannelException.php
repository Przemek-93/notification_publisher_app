<?php

declare(strict_types=1);

namespace App\NotificationPublisher\Domain\Exception;

use Exception;

class WrongNotificationChannelException extends Exception
{
    public const string MESSAGE = 'Notification channel "%s" not exists or is disabled. Please check in env if is enabled.';

    public function __construct(
        public string $channel,
    ) {
        parent::__construct(sprintf(self::MESSAGE, $channel));
    }
}
