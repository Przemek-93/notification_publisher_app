<?php

declare(strict_types=1);

namespace App\Shared\Infrastructure\Symfony\CQRS;

use App\Shared\CQRS\CommandBusInterface;
use App\Shared\CQRS\CommandInterface;
use Symfony\Component\Messenger\MessageBusInterface;

final readonly class CommandBus implements CommandBusInterface
{
    public function __construct(
        private MessageBusInterface $bus,
    ) {
    }

    public function dispatch(CommandInterface $command): void
    {
        $this->bus->dispatch($command);
    }
}
