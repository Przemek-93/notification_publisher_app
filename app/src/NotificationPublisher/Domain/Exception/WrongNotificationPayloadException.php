<?php

declare(strict_types=1);

namespace App\NotificationPublisher\Domain\Exception;

use Exception;

class WrongNotificationPayloadException extends Exception
{
    public const string MESSAGE = 'Wrong notification payload "%s"';

    public function __construct(
        public string $payloadClass,
    ) {
        parent::__construct(sprintf(self::MESSAGE,$payloadClass));
    }
}