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
        $user->setIdUser(1);
        $user->setPseudo("pseudo");
        $user->setName("name");
        $user->setFirstname("firstname");
        $user->setPhone(123456789);
        $user->setEmail("email");
        $user->setIsAdmin(false);
        $user->setPassword("password");
        $user->setIsRegisteredToEvent(true);

        $manager->persist($user);

        $manager->flush();
    }
}
