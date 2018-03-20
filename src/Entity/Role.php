<?php

declare(strict_types=1);

namespace App\Entity;

use Nette\Security\IRole;
use JMS\Serializer\Annotation\Type;

class Role implements IRole
{
    const GUEST = 'guest';
    const ADMIN = 'admin';

    const ALLOWED_ROLES = [
        self::GUEST,
        self::ADMIN,
    ];

    /**
     * @Type("string")
     *
     * @var string
     */
    protected $id;

    /**
     * Role constructor.
     *
     * @param string $id
     *
     * @throws \Exception
     */
    public function __construct(string $id)
    {
        if (!in_array($id, self::ALLOWED_ROLES)) {
            throw new \Exception(sprintf('Wrong role: \'%s\'', $id));
        }

        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getRoleId(): string
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->id;
    }
}
