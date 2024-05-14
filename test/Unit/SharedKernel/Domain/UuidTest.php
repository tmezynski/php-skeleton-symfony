<?php

declare(strict_types=1);

namespace Unit\SharedKernel\Domain;

use PHPUnit\Framework\Assert;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use SharedKernel\Domain\Uuid;

#[CoversClass(Uuid::class)]
final class UuidTest extends TestCase
{
    #[Test]
    public function generateRandomUuid(): void
    {
        $uuid1 = Uuid::generateRandom();
        $uuid2 = Uuid::generateRandom();

        Assert::assertTrue($uuid1->equals($uuid1));
        Assert::assertFalse($uuid1->equals($uuid2));
    }

    #[Test]
    public function generateFromUuidString(): void
    {
        $uuid1 = Uuid::fromUuidString('a6ef8e41-155b-4b92-8dd6-abd8383f99f4');
        $uuid2 = Uuid::fromUuidString('a6ef8e41-155b-4b92-8dd6-abd8383f99f4');

        Assert::assertEquals('a6ef8e41-155b-4b92-8dd6-abd8383f99f4', (string)$uuid1);
        Assert::assertTrue($uuid1->equals($uuid2));
    }

    #[Test]
    public function generateFromUuidStringAndNamespace(): void
    {
        $uuidString = '594df020-a5e7-471e-a820-ec2e9818e994';
        $namespace1 = '6e292281-3a77-4f22-89aa-08ff48d45060';
        $namespace2 = '6db9d2b3-c9d3-4807-9b30-4b6b668927d7';

        $uuid1 = Uuid::fromUuidStringAndNamespace($uuidString, $namespace1);
        $uuid2 = Uuid::fromUuidStringAndNamespace($uuidString, $namespace1);
        $uuid3 = Uuid::fromUuidStringAndNamespace($uuidString, $namespace2);

        Assert::assertTrue($uuid1->equals($uuid2));
        Assert::assertFalse($uuid2->equals($uuid3));
        Assert::assertEquals('80764b88-b503-5b6b-b972-c7e533a5d8c5', (string)$uuid1);
    }
}
