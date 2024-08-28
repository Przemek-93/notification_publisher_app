<?php

declare(strict_types=1);

namespace App\Tests\Sample;

use App\NotificationPublisher\Domain\Enum\NotificationChannel;
use Ramsey\Uuid\Uuid;

class NotificationSample
{
    public static function create(): array
    {
        return [
            'channels' => [NotificationChannel::EMAIL->value, NotificationChannel::SMS->value],
            'payload' => [
                'subject' => 'Test email subject',
                'content' => 'Test email text',
                'html' => 'Test email html',
            ],
            'recipients' => [
                [
                    'id' => Uuid::uuid4()->toString(),
                    'firstName' => 'John',
                    'lastName' => 'Doe',
                    'phone' => '+48511094325',
                    'email' => 'john.doe@example.com',
                ],
            ],
        ];
    }
}
