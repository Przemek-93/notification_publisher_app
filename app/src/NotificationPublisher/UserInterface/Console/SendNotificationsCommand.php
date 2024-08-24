<?php

declare(strict_types=1);

namespace App\NotificationPublisher\UserInterface\Console;

use App\NotificationPublisher\Application\CQRS\Command\SendNotification;
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
                'sms' => [
                    'messageBody' => 'Hi, your phone is under hacker attack!#@! wa$1l0$',
                ],
                'email' => [
                    'subject' => 'Test subject',
                    'text' => 'Test text',
                    'html' => 'Test html',
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

            $output->writeln('Send notification: start');

            $this->commandBus->dispatch(new SendNotification('sms', $payload, false));

            return Command::SUCCESS;
        } catch (Throwable $throwable) {
            $output->writeln(sprintf('Send notification error: "%s"', $throwable->getMessage()));

            return Command::FAILURE;
        }
    }
}
