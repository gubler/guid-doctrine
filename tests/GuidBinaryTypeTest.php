<?php

namespace Gubler\Guid\Doctrine\Tests;

use Gubler\Guid\Doctrine\GuidBinaryType;
use PHPUnit\Framework\TestCase;

/**
 * @covers \Gubler\Guid\Doctrine\GuidBinaryType
 */
final class GuidBinaryTypeTest extends TestCase
{
    public function testName(): void
    {
        $guidType = new GuidBinaryType();

        $this->assertEquals(GuidBinaryType::NAME, $guidType->getName());
    }
}
