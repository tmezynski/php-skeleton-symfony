<?php

declare(strict_types=1);

namespace SharedKernel\Infrastructure\Messenger\Serializer;

use RuntimeException;
use Symfony\Component\Messenger\Envelope;
use Symfony\Component\Messenger\Stamp\NonSendableStampInterface;
use Symfony\Component\Messenger\Stamp\SerializerStamp;
use Symfony\Component\Messenger\Stamp\StampInterface;
use Symfony\Component\Messenger\Transport\Serialization\SerializerInterface;
use Symfony\Component\Serializer\Serializer as SymfonySerializer;
use Throwable;
use Webmozart\Assert\Assert;

use function strlen;

final class JsonMessageSerializer implements SerializerInterface
{
    public const FORMAT = 'json';
    public const MESSENGER_SERIALIZATION_CONTEXT = 'messenger_serialization';
    private const STAMP_HEADER_PREFIX = 'X-Message-Stamp-';
    private const CONTEXT = [self::MESSENGER_SERIALIZATION_CONTEXT => true];
    private const HEADERS_FIELD = 'headers';
    private const BODY_FIELD = 'body';
    private const BODY_FIELD_CLASS = 'class';

    public function __construct(private readonly SymfonySerializer $serializer)
    {
    }

    /**
     * @phpcs:disable
     * @return array{
     *      headers: array<string, mixed>,
     *      body: string,
     * }
     * @phpcs:enable
     */
    public function encode(Envelope $envelope): array
    {
        /** @var ?SerializerStamp $serializerStamp */
        $serializerStamp = $envelope->last(SerializerStamp::class);
        $context = null !== $serializerStamp
            ? self::CONTEXT + $serializerStamp->getContext()
            : self::CONTEXT;

        $envelope = $envelope->withoutStampsOfType(NonSendableStampInterface::class);

        return [
            self::HEADERS_FIELD => $this->encodeStamps($envelope) + $this->getCustomStamps($envelope),
            self::BODY_FIELD => $this->serializer->serialize($envelope->getMessage(), self::FORMAT, $context),
        ];
    }

    /**
     * @phpcs:disable
     * @param array<string, mixed> $encodedEnvelope
     * @phpcs:enable
     */
    public function decode(array $encodedEnvelope): Envelope
    {
        $headers = $encodedEnvelope[self::HEADERS_FIELD] ?? null;
        Assert::isArray($headers, 'Headers should be an array');

        $className = $headers[self::BODY_FIELD_CLASS] ?? null;
        Assert::stringNotEmpty($className, 'Class name not defined');

        $body = $encodedEnvelope[self::BODY_FIELD] ?? null;
        Assert::stringNotEmpty($body, 'Body not found');

        $stamps = $this->decodeStamps($encodedEnvelope);
        $serializerStamp = $this->findFirstSerializerStamp($stamps);
        $context = null !== $serializerStamp
            ? self::CONTEXT + $serializerStamp->getContext()
            : self::CONTEXT;

        try {
            /** @var object $message */
            $message = $this->serializer->deserialize($body, $className, self::FORMAT, $context);
        } catch (Throwable $e) {
            throw new RuntimeException('Could not decode message: ' . $e->getMessage(), $e->getCode(), $e);
        }

        return new Envelope($message, $stamps);
    }

    /**
     * @phpcs:disable
     * @param array<string, mixed> $encodedEnvelope
     * @return StampInterface[]
     * @phpcs:enable
     */
    private function decodeStamps(array $encodedEnvelope): array
    {
        $stamps = [];
        $headers = is_array($encodedEnvelope[self::HEADERS_FIELD]) ? $encodedEnvelope[self::HEADERS_FIELD] : [];

        foreach ($headers as $name => $value) {
            if (!str_starts_with($name, self::STAMP_HEADER_PREFIX)) {
                continue;
            }

            try {
                /** @var StampInterface[] $deserialized */
                $deserialized = $this->serializer->deserialize(
                    $value,
                    substr($name, strlen(self::STAMP_HEADER_PREFIX)) . '[]',
                    self::FORMAT,
                    self::CONTEXT,
                );
                $stamps += array_values($deserialized);
            } catch (Throwable $e) {
                throw new RuntimeException(
                    'Could not decode stamp: ' . $e->getMessage(),
                    $e->getCode(),
                    $e
                );
            }
        }

        return $stamps;
    }

    /**
     * @phpcs:disable
     * @return array<string, mixed>
     * @phpcs:enable
     */
    private function encodeStamps(Envelope $envelope): array
    {
        $allStamps = $envelope->all();
        if (!$allStamps) {
            return [];
        }

        $headers = [];
        foreach ($allStamps as $class => $stamps) {
            $headers[self::STAMP_HEADER_PREFIX . $class] = $this->serializer->serialize(
                $stamps,
                self::FORMAT,
                self::CONTEXT,
            );
        }

        return $headers;
    }

    /**
     * @param StampInterface[] $stamps
     */
    private function findFirstSerializerStamp(array $stamps): ?SerializerStamp
    {
        foreach ($stamps as $stamp) {
            if ($stamp instanceof SerializerStamp) {
                return $stamp;
            }
        }

        return null;
    }

    /**
     * @return array<string, string>
     */
    private function getCustomStamps(Envelope $envelope): array
    {
        return [
            'Content-Type' => 'application/json',
            self::BODY_FIELD_CLASS => get_class($envelope->getMessage()),
        ];
    }
}
