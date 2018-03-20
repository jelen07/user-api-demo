<?php

declare(strict_types=1);

namespace App\Entity\Type;

use App\Entity\Name;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\StringType;

/**
 * @inheritdoc
 */
class NameType extends StringType
{
    const TYPE_NAME = 'name';

    /**
     * @param mixed $value
     * @param AbstractPlatform $platform
     * @return Name
     */
    public function convertToPHPValue($value, AbstractPlatform $platform): Name
    {
        return new Name($value);
    }

    /**
     * @param mixed $value
     * @param AbstractPlatform $platform
     * @return string
     */
    public function convertToDatabaseValue($value, AbstractPlatform $platform): string
    {
        return (string) $value;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return self::TYPE_NAME;
    }
}
