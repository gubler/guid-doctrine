<?php

namespace Gubler\Guid\Doctrine\Tests;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Mapping\Entity;
use Gubler\Guid\Doctrine\GuidGenerator;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Codec\GuidStringCodec;
use Ramsey\Uuid\Rfc4122\UuidV4;

/**
 * @covers \Gubler\Guid\Doctrine\GuidGenerator
 */
final class GuidGeneratorTest extends TestCase
{
    /**
     * Test that a UUIDv4 using the GuidStringCodec was generated.
     *
     * @throws \ReflectionException
     */
    public function testGeneratesWithGuidStringCodec(): void
    {
        $em = $this->createMock(EntityManager::class);
        $entity = new Entity();

        $generator = new GuidGenerator();

        $guid = $generator->generate($em, $entity);

        $reflect = new \ReflectionClass(UuidV4::class);
        $prop = $reflect->getProperty('codec');
        $prop->setAccessible(true);
        $codec = $prop->getValue($guid);

        $this->assertInstanceOf(UuidV4::class, $guid);
        $this->assertInstanceOf(GuidStringCodec::class, $codec);
    }
}
