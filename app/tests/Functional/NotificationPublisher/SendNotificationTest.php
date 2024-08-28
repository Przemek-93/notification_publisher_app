<?php

declare(strict_types=1);

namespace App\Tests\Functional\NotificationPublisher;

use App\NotificationPublisher\Domain\Exception\WrongNotificationChannelException;
use App\NotificationPublisher\Domain\Notifier\NotifierInterface;
use App\NotificationPublisher\NotificationPublisherFacade;
use App\Tests\Functional\FunctionalTestCase;
use App\Tests\Sample\NotificationSample;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;
use Symfony\Bundle\FrameworkBundle\Test\NotificationAssertionsTrait;
use Symfony\Component\Messenger\Exception\HandlerFailedException;

class SendNotificationTest extends FunctionalTestCase
{
    use NotificationAssertionsTrait;

    private NotificationPublisherFacade $notificationPublisherFacade;
    private array $sampleArray;

    protected function setUp(): void
    {
        parent::setUp();
        $this->notificationPublisherFacade = $this->container->get(NotificationPublisherFacade::class);
        $this->sampleArray = NotificationSample::create();
    }

    #[Test]
    public function itShouldSendNotification(): void
    {
        // when
        $this->notificationPublisherFacade->notify(json_encode($this->sampleArray));

        // then
        $this->assertNotificationCount(1);
        $this->assertNotificationSubjectContains($this->getNotifierMessages()[0], $this->sampleArray['payload']['subject']);
    }

    #[Test]
    public function itShouldThrowLimitExceedException(): void
    {
        // given
        $_ENV['NOTIFICATION_SEND_LIMIT'] = 1;

        // when
        $this->notificationPublisherFacade->notify(json_encode($this->sampleArray));

        // then
        $this->assertNotificationCount(1);
        $this->assertNotificationSubjectContains($this->getNotifierMessages()[0], $this->sampleArray['payload']['subject']);

        try {
            // when
            $this->notificationPublisherFacade->notify(json_encode($this->sampleArray));
        } catch (HandlerFailedException $exception) {
            // then
            $this->assertStringContainsString('Message send limit 1 exceed!', $exception->getMessage());
        }
    }

    #[Test]
    public function itShouldThrowWrongNotificationChannelException(): void
    {
        // given
        $this->sampleArray['channels'] = ['test'];

        try {
            // when
            $this->notificationPublisherFacade->notify(json_encode($this->sampleArray));
        } catch (HandlerFailedException $exception) {
            // then
            $this->assertStringContainsString(WrongNotificationChannelException::MESSAGE, $exception->getMessage());
        }
    }

    #[Test]
    public function itShouldThrowWrongNotificationChannelExceptionWhenAllChannelsAreDisabledByEnv(): void
    {
        // given
        $_ENV['MAIL_CHANNEL_ENABLED'] = 0;
        $_ENV['SMS_CHANNEL_ENABLED'] = 0;

        try {
            // when
            $this->notificationPublisherFacade->notify(json_encode($this->sampleArray));
        } catch (HandlerFailedException $exception) {
            // then
            $this->assertStringContainsString(WrongNotificationChannelException::MESSAGE, $exception->getMessage());
        }
    }

    #[Test]
    #[DataProvider('provideEnableChannel')]
    public function itShouldPassOnlyEnabledChannelToNotifier(
        int $emailEnabled,
        int $smsEnabled,
        array $channels,
    ): void {
        // given
        $_ENV['MAIL_CHANNEL_ENABLED'] = $emailEnabled;
        $_ENV['SMS_CHANNEL_ENABLED'] = $smsEnabled;
        $notifierMock = $this->createMock(NotifierInterface::class);
        $this->container->set(NotifierInterface::class, $notifierMock);

        // when
        $notifierMock
            ->expects($this->atLeastOnce())
            ->method('send')
            ->with(
                $this->anything(),
                $this->anything(),
                $this->equalTo($channels),
            );

        $this->notificationPublisherFacade->notify(json_encode($this->sampleArray));
    }

    public static function provideEnableChannel(): iterable
    {
        yield [1, 0, ['email']];
        yield [0, 1, ['sms']];
    }
}
