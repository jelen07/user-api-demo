<?php

declare(strict_types=1);

namespace App\Entity;

use App\Exception\InvalidArgumentException;
use Nette\Utils\Validators;

/**
 * Class Email
 * @package App\Entity
 */
class Email
{
    /**
     * @var string
     */
    private $email;

    /**
     * Email constructor.
     * @param string $email
     */
    public function __construct(string $email)
    {
        if (!Validators::isEmail($email)) {
            throw new InvalidArgumentException('Given email is invalid.');
        }

        $this->email = $email;
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->email;
    }
}
