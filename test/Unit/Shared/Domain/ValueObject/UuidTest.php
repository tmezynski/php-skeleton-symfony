<?php

declare(strict_types=1);

namespace Test\Unit\Shared\Domain\ValueObject;

use PHPUnit\Framework\Assert;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use Shared\Domain\ValueObject\Uuid\InvalidUuidException;
use Shared\Domain\ValueObject\Uuid\Uuid;

final class UuidTest extends TestCase
{
    #[Test]
    public function cannotCreateUuidFromInvalidString(): void
    {
        $this->expectException(InvalidUuidException::class);
        Uuid::fromString('invalid uuid');
    }

    #[Test]
    public function cannotCreateUuidFromInvalidStringAndValidNamespace(): void
    {
        $this->expectException(InvalidUuidException::class);
        Uuid::fromStringAndNamespace('invalid uuid', '01996b88-ba80-8705-79b8-dac4bebd7281');
    }

    #[Test]
    public function cannotCreateUuidFromValidStringAndInvalidNamespace(): void
    {
        $this->expectException(InvalidUuidException::class);
        Uuid::fromStringAndNamespace('01996b88-ba80-8705-79b8-dac4bebd7281', 'invalid uuid');
    }

    #[Test]
    public function generateValidRandomUuid(): void
    {
        $uuid1 = Uuid::generateRandom();
        $uuid2 = Uuid::generateRandom();

        Assert::assertTrue($uuid1->equals($uuid1));
        Assert::assertFalse($uuid1->equals($uuid2));
    }

    #[Test]
    public function canCreateValidUuidFromString(): void
    {
        $uuid = Uuid::fromString('a6ef8e41-155b-4b92-8dd6-abd8383f99f4');

        Assert::assertEquals('a6ef8e41-155b-4b92-8dd6-abd8383f99f4', $uuid->toString());
    }

    #[Test]
    public function canCreateValidUuidFromStringAndNamespace(): void
    {
        $uuidString = '594df020-a5e7-471e-a820-ec2e9818e994';
        $namespace1 = '6e292281-3a77-4f22-89aa-08ff48d45060';
        $namespace2 = '6db9d2b3-c9d3-4807-9b30-4b6b668927d7';

        $uuid1 = Uuid::fromStringAndNamespace($uuidString, $namespace1);
        $uuid2 = Uuid::fromStringAndNamespace($uuidString, $namespace1);
        $uuid3 = Uuid::fromStringAndNamespace($uuidString, $namespace2);

        Assert::assertTrue($uuid1->equals($uuid2));
        Assert::assertFalse($uuid2->equals($uuid3));
        Assert::assertEquals('80764b88-b503-5b6b-b972-c7e533a5d8c5', $uuid1->toString());
    }
}
