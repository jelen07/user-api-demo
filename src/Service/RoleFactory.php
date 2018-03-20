<?php

declare(strict_types=1);

namespace App\Service;

use App\Entity\AdminRole;
use App\Entity\GuestRole;
use Nette\Security\IRole;

/**
 * Simple RoleFactory
 * @package App\Service
 */
class RoleFactory implements IRoleFactory
{
    const ALLOWED_ROLES = [
        'admin',
        'guest',
    ];

    /**
     * @param string $name
     * @return IRole
     */
    public function createRole(string $name) : IRole
    {
        if (!in_array($name, self::ALLOWED_ROLES)) {
            throw new \Exception(sprintf('Wrong role: \'%s\'', $name));
        }

        switch ($name) {
            case 'admin':
                $role = new AdminRole();
                break;
            default:
                $role = new GuestRole();
                break;
        }

        return $role;
    }
}
