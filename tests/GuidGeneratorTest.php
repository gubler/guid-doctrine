<?php

namespace Gubler\Guid\Doctrine\Tests;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Mapping\Entity;
use Gubler\Guid\Doctrine\GuidGenerator;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Guid\Guid;

/**
 * @covers \Gubler\Guid\Doctrine\GuidGenerator
 */
final class GuidGeneratorTest extends TestCase
{
    /**
     * Test that a GUID was generated.
     *
     * @throws \ReflectionException
     */
    public function testGeneratesWithGuidStringCodec(): void
    {
        $em = $this->createMock(EntityManager::class);
        $entity = new Entity();

        $generator = new GuidGenerator();

        $guid = $generator->generate($em, $entity);

        $this->assertInstanceOf(Guid::class, $guid);
    }
}
