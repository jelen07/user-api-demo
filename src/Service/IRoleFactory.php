<?php

declare(strict_types=1);

namespace App\Service;

use Nette\Security\IRole;

interface IRoleFactory
{
    /**
     * @param string $name
     * @return IRole
     */
    function createRole(string $name) : IRole;
}
