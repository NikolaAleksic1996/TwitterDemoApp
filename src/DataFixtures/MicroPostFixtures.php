<?php

namespace App\DataFixtures;

use App\Entity\MicroPost;
use App\Entity\User;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class MicroPostFixtures extends BaseFixtures implements DependentFixtureInterface
{

    private static $microPostTitles = [
        'Why Asteroids Taste Like Bacon',
        'Life on Planet Mercury: Tan, Relaxing and Fabulous',
        'Light Speed Travel: Fountain of Youth or Fallacy',
    ];

    public function loadData(ObjectManager $manager)
    {
        $this->createMany(10, 'main_articles', function ($count) use ($manager) {
            $microPost = new MicroPost();
            $microPost->setText($this->faker->randomElement(self::$microPostTitles));
            $microPost->setCreatedAt($this->faker->dateTimeBetween('-100 days', '-1 days'));

            $microPost->setUser($this->getRandomReference('main_users'));

            return $microPost;
        });

        $manager->flush();
    }

    public function getDependencies()
    {
        return [
            UserFixture::class,

        ];
    }
}
