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

use InvalidArgumentException;
use Ramsey\Uuid\Codec\GuidStringCodec;
use Ramsey\Uuid\FeatureSet;
use Ramsey\Uuid\Guid\Guid;
use Ramsey\Uuid\UuidFactory;
use Doctrine\DBAL\Types\ConversionException;
use Doctrine\DBAL\Types\Type;
use Doctrine\DBAL\Platforms\AbstractPlatform;

/**
 * Field type mapping for the Doctrine Database Abstraction Layer (DBAL).
 *
 * GUID fields will be stored as a string in the database and converted back to
 * the GUID value object when querying.
 */
class GuidBinaryType extends Type
{
    /**
     * @var string
     */
    public const NAME = 'guid_binary';

    /**
     * {@inheritdoc}
     *
     * @param array            $fieldDeclaration
     * @param AbstractPlatform $platform
     */
    public function getSQLDeclaration(array $fieldDeclaration, AbstractPlatform $platform): string
    {
        return $platform->getBinaryTypeDeclarationSQL(
            array(
                'length' => '16',
                'fixed' => true,
            )
        );
    }

    /**
     * {@inheritdoc}
     *
     * @param string|null      $value
     * @param AbstractPlatform $platform
     *
     * @return Guid|null
     */
    public function convertToPHPValue($value, AbstractPlatform $platform)
    {
        if (empty($value)) {
            return null;
        }

        if ($value instanceof Guid) {
            return $value;
        }

        $useGuids = true;
        $featureSet = new FeatureSet($useGuids);
        $factory = new UuidFactory($featureSet);

        try {
            $guid = $factory->fromBytes($value);
        } catch (InvalidArgumentException $e) {
            throw ConversionException::conversionFailed($value, static::NAME);
        }

        return $guid;
    }

    /**
     * {@inheritdoc}
     *
     * @param Guid|null $value
     * @param AbstractPlatform   $platform
     */
    public function convertToDatabaseValue($value, AbstractPlatform $platform)
    {
        if (empty($value)) {
            return null;
        }

        if ($value instanceof Guid) {
            return $value->getBytes();
        }

        $factory = new UuidFactory();

        $codec = new GuidStringCodec($factory->getUuidBuilder());

        $factory->setCodec($codec);

        try {
            $uuid = $factory->fromString($value);
        } catch (InvalidArgumentException $e) {
            throw ConversionException::conversionFailed($value, static::NAME);
        }

        return $uuid->getBytes();
    }

    /**
     * {@inheritdoc}
     *
     * @return string
     */
    public function getName(): string
    {
        return static::NAME;
    }

    /**
     * {@inheritdoc}
     *
     * @param AbstractPlatform $platform
     *
     * @return boolean
     */
    public function requiresSQLCommentHint(AbstractPlatform $platform): bool
    {
        return true;
    }
}
