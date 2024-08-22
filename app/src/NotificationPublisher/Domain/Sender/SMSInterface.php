<?php

declare(strict_types=1);

namespace App\NotificationPublisher\Domain\Sender;

use App\NotificationPublisher\Domain\DTO\SMSPayloadDTO;

interface SMSInterface
{
    public function send(SMSPayloadDTO $SMSPayloadDTO): void;
}
