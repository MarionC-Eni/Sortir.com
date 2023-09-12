<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Event;
use Faker;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;


class EventFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {

        $faker = Faker\Factory::create('fr_FR');

        for ($i = 0; $i < 10; $i++) {
        $event = new Event();
        $event->setIdEvent($faker->numberBetween(1, 1000));
        $event->setName($faker->word());
        $event->setDateHourStart($faker->dateTime());

            $durationHours = $faker->numberBetween(0, 23);
            $durationMinutes = $faker->numberBetween(0, 59);

            $duration = new \DateTime();
            $duration->setTime($durationHours, $durationMinutes);

        $event->setDuration($duration);

        $event->setDateLimitInscription($faker->dateTime());

        $event->setNbInscriptionsMax($faker->numberBetween(1, 100));
        $event->setInfosEvent($faker->paragraph());
        $event->setReasonCancellation($faker->paragraph());

            //$event->setRoles( ["ROLE_USER"] );

        // On persiste
        $manager->persist($event);
    }
        $manager->flush();

}
}
