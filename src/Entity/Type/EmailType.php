<?php

declare(strict_types=1);

namespace App\Entity\Type;

use App\Entity\Email;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\StringType;

/**
 * Class EmailType.
 */
class EmailType extends StringType
{
    const TYPE_NAME = 'email';

    /**
     * @param mixed            $value
     * @param AbstractPlatform $platform
     *
     * @return Email
     */
    public function convertToPHPValue($value, AbstractPlatform $platform): Email
    {
        return new Email($value);
    }

    /**
     * @param mixed            $value
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
