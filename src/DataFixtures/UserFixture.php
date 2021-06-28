<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserFixture extends BaseFixtures
{

    private static $userNames = [
        'Bacon',
        'Fabulous',
        'Light',
        'Mercury',
        'Tan',
        'Life',
        'Main',
        'Speed',
        'Relaxing',
        'Tan',
    ];

    /**
     * @var UserPasswordEncoderInterface
     */
    private $passwordEncoder;

    public function __construct(UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->passwordEncoder = $passwordEncoder;
    }

    public function loadData(ObjectManager $manager)
    {
        $this->createMany(10, 'main_users', function ($i) use($manager) {
            $user = new User();
            $user->setEmail(sprintf('%dtest@gmail.com', $i));
            $user->setFullName($this->faker->firstName);
            $user->setUserName($this->faker->randomElement(self::$userNames));
            $user->setPassword($this->passwordEncoder->encodePassword(
                $user,
                'test'
            ));

            return $user;
        });

        $manager->flush();
    }

}