<?php

namespace App\DataFixtures;

use App\Entity\Utilisateurs;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\String\Slugger\SluggerInterface;

class UtilisateursFixtures extends Fixture
{

    public function __construct(
        private UserPasswordHasherInterface $passwordEncoder,
        private SluggerInterface $slugger)
    {

    }
    public function load(ObjectManager $manager): void
    {
        $admin = new Utilisateurs();
        $admin->setEmail('admin@demo.fr');
        $admin->setNom('Saantiz');
        $admin->setPrenom('Ryan');
        $admin->setPseudo('SaanTizz');
        $admin->setAdresse('12 rue du port');
        $admin->setCodepostal('75001');
        $admin->setVille('Paris');
        $admin->setTelephone('0650341125');
        $admin->setPassword($this->passwordEncoder->hashPassword($admin, 'admin'));
        $admin->setRoles(['ROLE_ADMIN']);

        $manager->persist($admin);

        $faker = Factory::create('fr_FR');

        for($usr = 1; $usr <=5; $usr++){
            $utilisateur = new Utilisateurs();
            $utilisateur->setEmail($faker->email);
            $utilisateur->setNom($faker->lastName);
            $utilisateur->setPrenom($faker->firstName);
            $utilisateur->setPseudo($faker->name);
            $utilisateur->setAdresse($faker->streetAddress);
            $utilisateur->setCodepostal(str_replace(' ', '', $faker->postcode));
            $utilisateur->setVille($faker->city);
            $utilisateur->setTelephone(str_replace(' ', '',
                $faker->serviceNumber));
            $utilisateur->setPassword($this->passwordEncoder->hashPassword
            ($utilisateur,
                'secret'));

            $manager->persist($utilisateur);
        }

        $manager->flush();
    }
}
