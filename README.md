# gubler/guid-doctrine

This is based off of the gubler/guid-doctrine project. The only thing it does differently
use the `GuidStringCodec` for the UUID. This to handle Active Directory GUIDs.

---

The gubler/guid-doctrine package provides the ability to use
[ramsey/uuid][ramsey-uuid] as a [Doctrine field type][doctrine-field-type].

This project adheres to a [Contributor Code of Conduct][conduct]. By participating in this project and its community, you are expected to uphold this code.

## Installation

The preferred method of installation is via [Packagist][] and [Composer][]. Run
the following command to install the package and add it as a requirement to
your project's `composer.json`:

```bash
composer require gubler/guid-doctrine
```

## Examples

### Configuration

To configure Doctrine to use gubler/guid as a field type, you'll need to set up
the following in your bootstrap:

``` php
\Doctrine\DBAL\Types\Type::addType('uuid', 'Gubler\Guid\Doctrine\GuidType');
```
In Symfony:
 ``` yaml
# config/packages/doctrine.yaml
doctrine:
    dbal:
        types:
            guid:  Gubler\Guid\Doctrine\GuidType
```
In Zend Framework:
```php
<?php 
// module.config.php
use Gubler\Guid\Doctrine\GuidType;

return [
    'doctrine' => [
        'configuration' => [
            'orm_default' => [
                'types' => [
                    GuidType::NAME => GuidType::class,
```

### Usage

Then, in your models, you may annotate properties by setting the `@Column`
type to `guid`, and defining a custom generator of `Gubler\Guid\GuidGenerator`.
Doctrine will handle the rest.

``` php
/**
 * @Entity
 * @Table(name="products")
 */
class Product
{
    /**
     * @var \Ramsey\Uuid\Uuid
     *
     * @Id
     * @Column(type="guid", unique=true)
     * @GeneratedValue(strategy="CUSTOM")
     * @CustomIdGenerator(class="Gubler\Guid\Doctrine\GuidGenerator")
     */
    protected $id;

    public function getId()
    {
        return $this->id;
    }
}
```

If you use the XML Mapping instead of PHP annotations.
``` XML
<id name="id" column="id" type="guid">
    <generator strategy="CUSTOM"/>
    <custom-id-generator class="Gubler\Guid\Doctrine\GuidGenerator"/>
</id>
```

You can also use the YAML Mapping.
``` yaml
id:
    id:
        type: guid
        generator:
            strategy: CUSTOM
        customIdGenerator:
            class: Gubler\Guid\Doctrine\GuidGenerator
```

### Binary Database Columns

In the previous example, Doctrine will create a database column of type `CHAR(36)`,
but you may also use this library to store GUIDs as binary strings. The
`GuidBinaryType` helps accomplish this.

In your bootstrap, place the following:

``` php
\Doctrine\DBAL\Types\Type::addType('guid_binary', 'Gubler\Guid\Doctrine\GuidBinaryType');
$entityManager->getConnection()->getDatabasePlatform()->registerDoctrineTypeMapping('guid_binary', 'binary');
```

In Symfony:
 ``` yaml
# config/packages/doctrine.yaml
doctrine:
    dbal:
        types:
            guid_binary:  Gubler\Guid\Doctrine\GuidBinaryType
        mapping_types:
            guid_binary: binary
```     

Then, when annotating model class properties, use `guid_binary` instead of `guid`:

    @Column(type="guid_binary")

### More Information

For more information on getting started with Doctrine, check out the "[Getting
Started with Doctrine][doctrine-getting-started]" tutorial.

## Contributing

Contributions are welcome! Please read [CONTRIBUTING][] for details.

## Copyright and License

The gubler/guid-doctrine library is copyright © [Daryl Gubler](http://dev88.co/) and
licensed for use under the MIT License (MIT). Please see [LICENSE][] for more
information.

[ramsey-uuid]: https://github.com/gubler/guid
[conduct]: https://github.com/gubler/guid-doctrine/blob/master/CODE_OF_CONDUCT.md
[doctrine-field-type]: http://doctrine-dbal.readthedocs.org/en/latest/reference/types.html
[packagist]: https://packagist.org/packages/gubler/guid-doctrine
[composer]: http://getcomposer.org/
[contributing]: https://github.com/gubler/guid-doctrine/blob/master/CONTRIBUTING.md
[doctrine-getting-started]: http://doctrine-orm.readthedocs.org/en/latest/tutorials/getting-started.html

[source]: https://github.com/gubler/guid-doctrine
[release]: https://packagist.org/packages/gubler/guid-doctrine
[license]: https://github.com/gubler/guid-doctrine/blob/master/LICENSE
[build]: https://travis-ci.org/gubler/guid-doctrine
[coverage]: https://coveralls.io/r/gubler/guid-doctrine?branch=master
[downloads]: https://packagist.org/packages/gubler/guid-doctrine
