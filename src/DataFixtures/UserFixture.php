<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class UserFixture extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $user = new User();
        $user->setUserName('kole_kole');
        $user->setFullName('Nikola Aleksic');
        $user->setEmail('al_kol@gmail.com');

        $manager->persist($user);
        $manager->flush();
    }
}