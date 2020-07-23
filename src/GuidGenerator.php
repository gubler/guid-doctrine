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
use Ramsey\Uuid\FeatureSet;
use Ramsey\Uuid\Guid\Guid;
use Ramsey\Uuid\UuidFactory;

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
     * @return Guid
     */
    public function generate(EntityManager $em, $entity): Guid
    {
        $useGuids = true;
        $featureSet = new FeatureSet($useGuids);
        $factory = new UuidFactory($featureSet);

        return $factory->uuid4();
    }
}
