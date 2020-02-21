<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Common\Persistence\ObjectManager;

class UserFixture extends BaseFixture
{
    protected function loadData(ObjectManager $manager)
    {
        $this->createMany(10, 'main_users', function ($i) {
            $user = new User();
            $user->setEmail(sprintf('asd%d@asd.lt', $i));
            $user->setName($this->faker->name);
            $user->setActive(true);
            $user->setLastLogin(new \DateTime());

            return $user;
        });

        $manager->flush();
    }
}
