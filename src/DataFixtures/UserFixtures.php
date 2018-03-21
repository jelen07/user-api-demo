<?php

declare(strict_types=1);

namespace App\DataFixtures;

use App\Entity\Email;
use App\Entity\Name;
use App\Entity\Password;
use App\Entity\Role;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Faker\Factory;
use Faker\Generator;

/**
 * Class UserFixtures.
 */
class UserFixtures extends Fixture
{
    const COUNT = 122;

    /**
     * @var Generator
     */
    private $generator;

    /**
     * UserFixtures constructor.
     */
    public function __construct()
    {
        $this->generator = Factory::create();
    }

    /**
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager): void
    {
        $roles = [
            new Role('guest'),
            new Role('admin'),
        ];

        for ($i = 0; $i < self::COUNT; ++$i) {
            $user = new User(
                new Name($this->generator->name),
                new Email($this->generator->email),
                new Password($this->generator->password(6, 10)),
                $roles[array_rand($roles)]
            );
            $manager->persist($user);
        }

        usleep(1000);

        $user = new User(
            new Name('Vojtěch Lacina'),
            new Email('MoraviaD1@gmail.com'),
            new Password('password(lol)'),
            new Role('admin')
        );
        $manager->persist($user);

        $manager->flush();
    }
}
