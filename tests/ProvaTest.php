<?php

use GGGGino\WarehousePath\Prova;
use PHPUnit\Framework\TestCase;

final class ProvaTest extends TestCase
{
    public function testCanBeCreatedFromValidEmailAddress(): void
    {
        $this->assertInstanceOf(
            Prova::class,
            Prova::fromString('user@example.com')
        );
    }

    public function testCannotBeCreatedFromInvalidEmailAddress(): void
    {
        $this->expectException(InvalidArgumentException::class);

        Prova::fromString('invalid');
    }

    public function testCanBeUsedAsString(): void
    {
        $this->assertEquals(
            'user@example.com',
            Prova::fromString('user@example.com')
        );
    }
}