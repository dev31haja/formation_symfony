<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserFixtures extends Fixture
{
    private $pwd_hasher;
    public function __construct(UserPasswordHasherInterface $hasher)
    {
        $this->pwd_hasher = $hasher;
    }

    public function load(ObjectManager $manager)
    {
        $roles = ['ROLE_ADMIN','ROLE_MANAGER','ROLE_USER'];
        $cpt = 0;
        foreach($roles as $role){
            $user = new User();
            $user->setEmail('user'.$cpt.'@toto.fr');
            $user->setPassword($this->pwd_hasher->hashPassword($user, 'pwd'.$cpt));
            $user->setRoles([$role]);
            $manager->persist($user);
            $cpt++;
        }

        $manager->flush();
    }
}
