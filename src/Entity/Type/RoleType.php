<?php

declare(strict_types=1);

namespace App\Entity\Type;

use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\Type;
use Nette\Security\IRole;

/**
 * Class RoleType
 * @package App\Entity\Type
 */
class RoleType extends Type
{
    const TYPE_NAME = 'role';
    /**
     * @param array $fieldDeclaration
     * @param AbstractPlatform $platform
     *
     * @return string
     */
    public function getSQLDeclaration(array $fieldDeclaration, AbstractPlatform $platform): string
    {
        return ucfirst(self::TYPE_NAME);
    }

    /**
     * @param mixed $value
     * @param AbstractPlatform $platform
     *
     * @return IRole
     */
    public function convertToPHPValue($value, AbstractPlatform $platform): IRole
    {
        $className = sprintf('App\\Entity\\%sRole', ucfirst($value));
        return new $className($value);
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
