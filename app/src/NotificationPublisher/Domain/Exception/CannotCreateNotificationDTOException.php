<?php

declare(strict_types=1);

namespace App\NotificationPublisher\Domain\Exception;

use Exception;
use Throwable;

class CannotCreateNotificationDTOException extends Exception
{
    public const string MESSAGE = 'Error occurs while trying to create notificationDTO. Error: "%s"';

    public function __construct(
        string $error,
        ?Throwable $previous = null
    ) {
        parent::__construct(sprintf(self::MESSAGE, $error), previous: $previous);
    }
}
