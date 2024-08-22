<?php

declare(strict_types=1);

namespace App\Shared\Infrastructure\Symfony\Serializer;

use App\Shared\Serializer\Format;
use App\Shared\Serializer\SerializerInterface;
use Symfony\Component\Serializer\SerializerInterface as SymfonySerializerInterface;

final readonly class Serializer implements SerializerInterface
{
    public function __construct(
        private SymfonySerializerInterface $serializer,
    ) {
    }

    /** @param array<string, mixed> $context */
    public function serialize(mixed $data, Format $format = Format::json, array $context = []): string
    {
        return $this->serializer->serialize($data, $format->value, $context);
    }

    /** @param array<string, mixed> $context */
    public function deserialize(mixed $data, string $type, Format $format = Format::json, array $context = []): mixed
    {
        return $this->serializer->deserialize($data, $type, $format->value, $context);
    }
}
