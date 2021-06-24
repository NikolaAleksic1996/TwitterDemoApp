<?php

namespace App\DataFixtures;

use App\Entity\MicroPost;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserFixture extends Fixture
{


    /**
     * @var UserPasswordEncoderInterface
     */
    private $passwordEncoder;

    public function __construct(UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->passwordEncoder = $passwordEncoder;
    }

    public function load(ObjectManager $manager)
    {
        $user = new User();
        $user->setUserName('kole_kole');
        $user->setFullName('Nikola Aleksic');
        $user->setEmail('al_kol@gmail.com');
        $user->setPassword($this->passwordEncoder->encodePassword(
            $user,
            'test'
        ));

        $user1 = new User();
        $user1->setUserName('kole_kole1');
        $user1->setFullName('Milan Aleksic');
        $user1->setEmail('al_mil@gmail.com');
        $user1->setPassword($this->passwordEncoder->encodePassword(
            $user,
            'test'
        ));

        $microPost = new MicroPost();
        $microPost->setText('First post on Twitter');
        $microPost->setCreatedAt(new \DateTime('now'));
        $microPost->setUser($user);

        $microPost1 = new MicroPost();
        $microPost1->setText('Second post on Twitter');
        $microPost1->setCreatedAt(new \DateTime('now'));
        $microPost1->setUser($user);

        $manager->persist($microPost);
        $manager->persist($microPost1);
        $manager->persist($user);
        $manager->persist($user1);
        $manager->flush();
    }
}