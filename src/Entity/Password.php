<?php

declare(strict_types=1);

namespace App\Entity;

use Nette\Security\Passwords;

class Password
{
    /**
     * @var string
     */
    private $password;

    /**
     * Password constructor.
     * @param string $password
     */
    public function __construct(string $password)
    {
        $this->password = Passwords::needsRehash($password)
            ? Passwords::hash($password)
            : $password;
    }

    /**
     * @param string $password
     *
     * @return bool
     */
    public function comparePasswords($password) : bool
    {
        $hash = Passwords::needsRehash($this->password) ? Passwords::hash($this->password) : $this->password;

        return Passwords::verify($password, $hash);
    }

    /**
     * @return string
     */
    public function __toString() : string
    {
        return $this->password;
    }
}
