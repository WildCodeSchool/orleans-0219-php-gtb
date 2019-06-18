<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserFixtures extends Fixture
{
    private $passwordEncoder;

    public function __construct(UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->passwordEncoder = $passwordEncoder;
    }


    public function load(ObjectManager $manager)
    {
        $user = new User();
        $user->setEmail('member@gtb.com');
        $user->setRoles(['ROLE_MEMBER']);
        $user->setPassword($this->passwordEncoder->encodePassword($user, 'memberpassword'));
        $manager->persist($user);

        $user = new User();
        $user->setEmail('memberoffice@gtb.com');
        $user->setRoles(['ROLE_OFFICE']);
        $user->setPassword($this->passwordEncoder->encodePassword($user, 'officepassword'));
        $manager->persist($user);

        $user = new User();
        $user->setEmail('admin@gtb.com');
        $user->setRoles(['ROLE_ADMIN']);
        $user->setPassword($this->passwordEncoder->encodePassword($user, 'adminpassword'));
        $manager->persist($user);

        $manager->flush();
    }
}
