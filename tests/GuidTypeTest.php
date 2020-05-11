<?php

namespace Gubler\Guid\Doctrine\Tests;

use PHPUnit\Framework\TestCase;
use Gubler\Guid\Doctrine\GuidType;

/**
 * @covers \Gubler\Guid\Doctrine\GuidType
 */
final class GuidTypeTest extends TestCase
{
    public function testName(): void
    {
        $guidType = new GuidType();

        $this->assertEquals(GuidType::NAME, $guidType->getName());
    }
}
