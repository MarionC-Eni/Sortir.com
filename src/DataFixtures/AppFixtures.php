<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\User;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $user = new User();
        $user->setPseudo("pseudo");
        $user->setName("name");
        $user->setFirstname("firstname");
        $user->setPhone("phone");
        $user->setEmail("email");
        $user->setPassword("password");

        $manager->persist($user);

        $manager->flush();
    }
}
