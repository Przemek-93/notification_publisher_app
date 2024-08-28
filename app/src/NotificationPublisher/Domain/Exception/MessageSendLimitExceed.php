<?php

declare(strict_types=1);

namespace App\NotificationPublisher\Domain\Exception;

use Exception;

class MessageSendLimitExceed extends Exception
{
    public const string MESSAGE = 'Message send limit %d exceed! Retry after: %d minutes';

    public function __construct(
        int $limit,
        float $retryAfter,
    ) {
        parent::__construct(sprintf(self::MESSAGE, $limit, $retryAfter));
    }
}
