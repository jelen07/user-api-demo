<?php

declare(strict_types=1);

namespace App\Entity;

use Nette\Security\IRole;

/**
 * Class AbstractRole
 * @package App\Entity
 */
abstract class AbstractRole implements IRole
{
    /**
     * @var string
     */
    protected $id;

    /**
     * @return string
     */
    public function getRoleId() : string
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function __toString() : string
    {
        return $this->id;
    }
}
