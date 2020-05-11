<?php
/**
 * This file is part of the gubler/guid-doctrine library
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @copyright Copyright (c) Daryl Gubler <http://dev88.co>
 * @license http://opensource.org/licenses/MIT MIT
 * @link https://packagist.org/packages/gubler/guid-doctrine Packagist
 * @link https://github.com/gubler/guid-doctrine GitHub
 */

namespace Gubler\Guid\Doctrine;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Id\AbstractIdGenerator;
use Ramsey\Uuid\Codec\GuidStringCodec;
use Ramsey\Uuid\UuidFactory;
use Ramsey\Uuid\UuidInterface;

/**
 * GUID generator for the Doctrine ORM.
 */
class GuidGenerator extends AbstractIdGenerator
{
    /**
     * Generate an identifier
     *
     * @param EntityManager                $em
     * @param \Doctrine\ORM\Mapping\Entity $entity
     * @return UuidInterface
     */
    public function generate(EntityManager $em, $entity): UuidInterface
    {
        $factory = new UuidFactory();

        $codec = new GuidStringCodec($factory->getUuidBuilder());

        $factory->setCodec($codec);

        return $factory->uuid4();
    }
}
