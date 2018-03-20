<?php

declare(strict_types=1);

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Nette\Security\IRole;

/**
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
 */
class User
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="name", length=25)
     *
     * @var string
     */
    private $name;

    /**
     * @ORM\Column(type="email", length=255, unique=true)
     *
     * @var Email
     */
    private $email;

    /**
     * @ORM\Column(type="password", length=255)
     *
     * @var string
     */
    private $password;

    /**
     * @ORM\Column(type="role", length=10)
     *
     * @var IRole
     */
    private $role;

    /**
     * @ORM\Column(type="datetime")
     *
     * @var \DateTime
     */
    private $created;

    /**
     * @ORM\Column(type="datetime")
     *
     * @var \DateTime
     */
    private $updated;

    /**
     * User constructor.
     * @param Name $name
     * @param Email $email
     * @param Password $password
     * @param IRole $role
     */
    public function __construct(Name $name, Email $email, Password $password, IRole $role)
    {
        $this->name = $name;
        $this->email = $email;
        $this->password = $password;
        $this->role = $role;
        $this->created = new \DateTime('now');
        $this->updated = new \DateTime('now');
    }

    /**
     * @ORM\PreUpdate
     *
     * @return void
     */
    public function onPreUpdate(): void
    {
        $this->updated = new \DateTime('now');
    }

    /**
     * @return Name
     */
    public function getName(): Name
    {
        return $this->name;
    }

    /**
     * @return Email
     */
    public function getEmail(): Email
    {
        return $this->email;
    }

    /**
     * @return Password
     */
    public function getPassword(): Password
    {
        return $this->password;
    }

    /**
     * @return IRole
     */
    public function getRole(): IRole
    {
        return $this->role;
    }
}
