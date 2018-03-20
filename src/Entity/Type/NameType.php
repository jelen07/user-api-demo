<?php

declare(strict_types=1);

namespace App\Entity\Type;

use App\Entity\Name;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\Type;

/**
 * @inheritdoc
 */
class NameType extends Type
{
    const TYPE_NAME = 'name';

    /**
     * @inheritdoc
     */
    public function getSQLDeclaration(array $fieldDeclaration, AbstractPlatform $platform): string
    {
        return ucfirst(self::TYPE_NAME);
    }

    /**
     * @param mixed $value
     * @param AbstractPlatform $platform
     *
     * @return Name
     */
    public function convertToPHPValue($value, AbstractPlatform $platform): Name
    {
        return new Name($value);
    }

    /**
     * @inheritdoc
     */
    public function convertToDatabaseValue($value, AbstractPlatform $platform): string
    {
        return (string) $value;
    }

    /**
     * @inheritdoc
     */
    public function getName(): string
    {
        return self::TYPE_NAME;
    }
}
