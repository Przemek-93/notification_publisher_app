<?php

declare(strict_types=1);

namespace App\NotificationPublisher\Infrastructure\Sender\SMS;

use App\NotificationPublisher\Domain\DTO\SMSPayloadDTO;
use App\NotificationPublisher\Domain\Sender\SMSInterface;
use Twilio\Rest\Client;

final readonly class SMS implements SMSInterface
{
    public function __construct(
        private string $sid,
        private string $authToken,
        private string $fromNumber,
    ) {
    }

    public function send(SMSPayloadDTO $SMSPayloadDTO): void
    {
        $twilio = new Client($this->sid, $this->authToken);

        $twilio->messages->create(
            $SMSPayloadDTO->recipientNumber,
            [
                'from' => $this->fromNumber,
                'body' => $SMSPayloadDTO->messageBody,
            ]
        );
    }
}
