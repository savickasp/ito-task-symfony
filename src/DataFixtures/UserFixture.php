<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserFixture extends BaseFixture
{
    private $passwordEncoder;

    public function __construct(UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->passwordEncoder = $passwordEncoder;
    }

    protected function loadData(ObjectManager $manager)
    {
        $this->createMany(10, 'main_users', function ($i) {
            $user = new User();
            $user->setEmail(sprintf('asd%d@asd.lt', $i));
            $user->setName($this->faker->name);
            $user->setActive(true);
            $user->setLastLogin(new \DateTime());
            $user->setPassword($this->passwordEncoder->encodePassword($user, 'password'));

            return $user;
        });

        $manager->flush();
    }
}
