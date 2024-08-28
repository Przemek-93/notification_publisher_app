<?php

declare(strict_types=1);

namespace App\Tests\Unit\NotificationPublisher\Domain\Factory;

use App\NotificationPublisher\Domain\Exception\CannotCreateNotificationDTOException;
use App\NotificationPublisher\Domain\Factory\NotificationDTOFactory;
use App\Shared\Serializer\SerializerInterface;
use App\Tests\Sample\NotificationSample;
use App\Tests\Unit\UnitTestCase;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;
use Throwable;

class NotificationDTOFactoryTest extends UnitTestCase
{
    private array $channelsConfig = ['email' => true, 'sms' => true];
    private array $sampleArray;
    private SerializerInterface $serializer;

    protected function setUp(): void
    {
        parent::setUp();
        $this->sampleArray = NotificationSample::create();
        $this->serializer = $this->container->get(SerializerInterface::class);
    }

    #[Test]
    public function itShouldCreateSuccessfully(): void
    {
        // given
        $factory = new NotificationDTOFactory(
            $this->channelsConfig,
            $this->serializer
        );

        // when
        $notificationDTO = $factory->create(
            $this->sampleArray['channels'],
            $this->sampleArray['payload'],
            $this->sampleArray['recipients'],
        );

        // then
        $this->assertEquals($this->sampleArray['payload']['subject'], $notificationDTO->payload->subject);
        $this->assertEquals($this->sampleArray['payload']['content'], $notificationDTO->payload->content);
        $this->assertEquals($this->sampleArray['channels'], $notificationDTO->enabledChannels);
    }

    #[Test]
    #[DataProvider('wrongDataProvider')]
    public function itShouldThrowExceptionDueToLackOfData(array $dataSet): void
    {
        // given
        $factory = new NotificationDTOFactory(
            $this->channelsConfig,
            $this->serializer
        );

        $this->sampleArray[$dataSet['field']] = $dataSet['value'];

        try {
            // when
            $factory->create(
                $this->sampleArray['channels'],
                $this->sampleArray['payload'],
                $this->sampleArray['recipients'],
            );
        } catch (Throwable $throwable) {
            // then
            $this->assertInstanceOf(CannotCreateNotificationDTOException::class, $throwable);
            $this->assertStringContainsString('Error occurs while trying to create notificationDTO', $throwable->getMessage());
        }
    }

    public static function wrongDataProvider(): iterable
    {
        yield [['field' => 'channels', 'value' => ['test']]];
        yield [['field' => 'payload', 'value' => ['subject' => 1, 'content' => 2]]];
        yield [['field' => 'recipients', 'value' => ['test']]];
    }

    #[Test]
    #[DataProvider('channelsDataProvider')]
    public function itShouldPassOnlyEnableChannels(array $dataSet): void
    {
        // given
        $factory = new NotificationDTOFactory(
            $dataSet['channelsConfig'],
            $this->serializer
        );
        $this->sampleArray['channels'] = $dataSet['payloadChannels'];

        $notificationDTO = $factory->create(
            $this->sampleArray['channels'],
            $this->sampleArray['payload'],
            $this->sampleArray['recipients'],
        );

        $this->assertEquals($dataSet['result'], $notificationDTO->enabledChannels);
    }

    public static function channelsDataProvider(): iterable
    {
        yield [['channelsConfig' => ['email' => true, 'sms' => true], 'payloadChannels' => ['email', 'sms'], 'result' => ['email', 'sms']]];
        yield [['channelsConfig' => ['email' => false, 'sms' => true], 'payloadChannels' => ['email', 'sms'], 'result' => ['sms']]];
        yield [['channelsConfig' => ['email' => true, 'sms' => false], 'payloadChannels' => ['email', 'sms'], 'result' => ['email']]];
        yield [['channelsConfig' => ['email' => false, 'sms' => true], 'payloadChannels' => ['sms'], 'result' => ['sms']]];
        yield [['channelsConfig' => ['email' => true, 'sms' => false], 'payloadChannels' => ['email'], 'result' => ['email']]];
    }
}
