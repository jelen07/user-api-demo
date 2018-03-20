<?php

declare(strict_types=1);

namespace App\Entity\Type;

use App\Entity\Password;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\StringType;

/**
 * Class PasswordType
 * @package App\Entity\Type
 */
class PasswordType extends StringType
{
    const TYPE_NAME = 'password';

    /**
     * @param mixed $value
     * @param AbstractPlatform $platform
     *
     * @return Password
     */
    public function convertToPHPValue($value, AbstractPlatform $platform): Password
    {
        return new Password($value);
    }

    /**
     * @param mixed $value
     * @param AbstractPlatform $platform
     *
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
