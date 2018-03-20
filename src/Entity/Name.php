<?php

declare(strict_types=1);

namespace App\Entity;

use App\Exception\InvalidArgumentException;
use JMS\Serializer\Annotation\Type;

/**
 * Class Name.
 */
class Name
{
    /**
     * @Type("string")
     *
     * @var string
     */
    private $name;

    /**
     * Name constructor.
     *
     * @param string $name
     */
    public function __construct(string $name)
    {
        if (empty($name)) {
            throw new InvalidArgumentException('Name could not be empty!');
        }

        $this->name = $name;
    }

    public function __toString(): string
    {
        return $this->name;
    }
}
