<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\User;
use Faker;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;


class UserFixtures extends Fixture

{
    private UserPasswordHasherInterface $hasher;
    // ou bien sans typage (moins bien) :
    // private $hasher

    public function __construct(UserPasswordHasherInterface $hasher)
    {
        $this->hasher = $hasher;
    }

    public function load(ObjectManager $manager): void
    {

        $faker = Faker\Factory::create('fr_FR');

        for ($i = 0; $i < 10; $i++) {
        $user = new User();
        $user->setIdUser($faker->numberBetween(1, 1000));
        $user->setPseudo($faker->firstName());
        $user->setName($faker->lastName());
        $user->setFirstname($faker->firstName());
        $user->setPhone($faker->phoneNumber());
        $user->setEmail($faker->email());
        $user->setIsAdmin($faker->boolean);
        $user->setPassword($faker->password);
        $user->setIsRegisteredToEvent($faker->boolean);

        //$user->setRoles( ["ROLE_USER"] );

        $sPlainPassword = "azerty123";
        // $user->setPassword($PlainPassword);

         $hash = $this->hasher->hashPassword($user, $sPlainPassword);
        $user->setPassword($hash);

        // On persiste
        $manager->persist($user);
    }
        $manager->flush();
}
}
