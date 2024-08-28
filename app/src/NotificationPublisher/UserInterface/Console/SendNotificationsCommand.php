<?php

declare(strict_types=1);

namespace App\NotificationPublisher\UserInterface\Console;

use App\NotificationPublisher\Application\CQRS\Command\SendNotification;
use App\NotificationPublisher\Domain\Enum\NotificationChannel;
use App\Shared\CQRS\CommandBusInterface;
use Ramsey\Uuid\Uuid;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Throwable;

#[AsCommand(
    name: 'notification:send',
    description: 'Send notifications to users',
)]
final class SendNotificationsCommand extends Command
{
    public function __construct(
        private readonly CommandBusInterface $commandBus,
    ) {
        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        try {
            $payload = [
                'subject' => 'Test email subject',
                'content' => 'Test email text',
                'html' => 'Test email html',
            ];

            $recipients = [
                [
                    'id' => Uuid::uuid4()->toString(),
                    'firstName' => 'John',
                    'lastName' => 'Doe',
                    'phone' => '+48111111111',
                    'email' => 'john.doe@example.com',
                ],
            ];

            $output->writeln('Send notification: start');

            $this->commandBus->dispatch(
                new SendNotification(
                    [NotificationChannel::EMAIL->value, NotificationChannel::SMS->value],
                    $payload,
                    $recipients,
                ),
            );

            return Command::SUCCESS;
        } catch (Throwable $throwable) {
            $output->writeln(sprintf('Send notification error: "%s"', $throwable->getMessage()));

            return Command::FAILURE;
        }
    }
}
