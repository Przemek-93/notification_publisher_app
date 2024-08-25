<?php

declare(strict_types=1);

namespace App\NotificationPublisher\Infrastructure\Sender\SMS;

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

    public function send(
        string $messageBody,
        string $toNumber,
    ): void {
        $twilio = new Client($this->sid, $this->authToken);

        $twilio->messages->create(
            $toNumber,
            [
                'from' => $this->fromNumber,
                'body' => $messageBody,
            ]
        );
    }
}
