<?php

declare(strict_types=1);

namespace App\Entity\Type;

use App\Entity\Role;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\StringType;
use Nette\Security\IRole;

/**
 * Class RoleType.
 */
class RoleType extends StringType
{
    const TYPE_NAME = 'role';

    /**
     * @param mixed            $value
     * @param AbstractPlatform $platform
     *
     * @return IRole
     */
    public function convertToPHPValue($value, AbstractPlatform $platform): IRole
    {
        return new Role($value);
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
