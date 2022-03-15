<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\User;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AppFixtures extends Fixture
{
    private $passwordEncoder;
    
    public function __construct(UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->passwordEncoder = $passwordEncoder;
    }
    public function load(ObjectManager $manager): void
    {
        // $product = new Product();
        // $manager->persist($product);

        $user = new User();
        $user->setusername('admin@jmail.com');
        $roles[] = 'ROLE_SUPER_ADMIN';
        $user->setRoles($roles);
        $password = $this->passwordEncoder->encodePassword($user, "123456789Az.");
        $user->setPassword($password);
        $manager->persist($user);

        
        
        $manager->flush();
    }
}
