<?php

declare(strict_types=1);

namespace SharedKernel\Unit\Domain;

use InvalidArgumentException;
use PHPUnit\Framework\TestCase;
use SharedKernel\Domain\Uuid;

final class UuidTest extends TestCase
{
    /**
     * @return array<int, array<int, string|null>>
     */
    public static function wrongValuesDataProvider(): array
    {
        return [
            ['abc', null],
            ['6d175f60-4004-445e-9498-7926c5a3019f', 'abc'],
        ];
    }

    /**
     * @dataProvider wrongValuesDataProvider
     */
    public function testCanNotGenerateUuidFromWrongValues(?string $value = null, ?string $namespace = null): void
    {
        $this->expectException(InvalidArgumentException::class);

        Uuid::generate($value, $namespace);
    }

    /**
     * @return array<int, array<int, string|null>>
     */
    public static function uuidGenerationDataProvider(): array
    {
        return [
            [null, null, null],
            ['6d175f60-4004-445e-9498-7926c5a3019f', null, '6d175f60-4004-445e-9498-7926c5a3019f'],
        ];
    }

    /**
     * @dataProvider uuidGenerationDataProvider
     */
    public function testGenerate(?string $value, ?string $namespace, ?string $expected): void
    {
        $id = Uuid::generate($value, $namespace);
        $id2 = Uuid::generate();

        if (null !== $expected) {
            $this->assertEquals($expected, (string)$id);
        }
        $this->assertFalse($id->equals($id2));
    }
}
