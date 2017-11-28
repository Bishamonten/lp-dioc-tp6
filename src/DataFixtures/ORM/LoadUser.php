<?php

namespace App\DataFixtures\ORM;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class LoadUser extends Fixture
{
    const USER_PASSWORD = 'user';

    public function load(ObjectManager $manager)
    {
        $user = new User();

        $user->setFirstname('John');
        $user->setLastname('Doe');
        $user->setEmail('user@exemple.org');

        $password = $this->container->get('security.password_encoder')->encodePassword($user, self::USER_PASSWORD);
        $user->setPassword($password);

        $this->addReference('user', $user);

        $manager->persist($user);
        $manager->flush();
    }
}
