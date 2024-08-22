<?php

declare(strict_types=1);

namespace App\NotificationPublisher\Domain\Exception;

use Exception;

class WrongNotificationChannelException extends Exception
{
    public const string MESSAGE = 'Notification channel "%s" not exists!';

    public function __construct(
        public string $channel,
    ) {
        parent::__construct(sprintf(self::MESSAGE, $channel));
    }
}
