<?php

namespace App\DataFixtures;

use DateTime;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserFixtures extends Fixture
{
    private string                       $password;
    private string                       $email;
    private UserPasswordEncoderInterface $encoder;

    public function __construct(UserPasswordEncoderInterface $encoder, string $secretPasswordWord, string $defaultUserEmail)
    {
        $this->password = $secretPasswordWord;
        $this->encoder  = $encoder;
        $this->email    = $defaultUserEmail;
    }

    public function load(ObjectManager $manager)
    {
        $user = new User();
        $user->setEmail($this->email);
        $user->setPassword($this->encoder->encodePassword($user, $this->password));
        $manager->persist($user);
        $manager->flush();
    }
}
