<?php

declare(strict_types=1);

namespace App\Entity;

/**
 * Class GuestRole
 * @package App\Entity
 */
class GuestRole extends AbstractRole
{
    /**
     * GuestRole constructor.
     */
    public function __construct()
    {
        $this->id = 'guest';
    }
}
