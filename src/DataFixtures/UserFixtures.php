<?php


namespace App\DataFixtures;


use App\Entity\User;
use App\Service\Slugify;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserFixtures extends Fixture
{

    const ROLE = [
        'guest',
        'admin'
    ];

    private $passwordEncoder;

    public function __construct(UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->passwordEncoder = $passwordEncoder;
    }

    /**
     * @inheritDoc
     * @throws \Exception
     */
    public function load(ObjectManager $manager)
    {
        $slugify = new Slugify();
        $faker = Factory::create('fr_FR');
        for ($i = 0; $i <= 5; $i++) {
            $id = random_int(1, 4);
            $user = new User();
            $user->setEmail('user' . $i . '@wild-series.fr');
            $user->setRoles(['ROLE_USER']);
            $user->setUsername($slugify->generate($faker->firstName()));
            $user->setCreatedAt($faker->dateTime);
            $user->setAvatar('avatar' . $id . '.png');
            $user->setPassword($this->passwordEncoder->encodePassword(
                $user,
                'user'
            ));

            $manager->persist($user);
        }

        // Création d’un utilisateur de type “administrateur”
        $admin = new User();
        $admin->setEmail('admin@monsite.com');
        $admin->setRoles(['ROLE_ADMIN']);
        $admin->setUsername($slugify->generate($faker->firstName()));
        $admin->setCreatedAt($faker->dateTime);
        $admin->setAvatar('admin.png');
        $admin->setPassword($this->passwordEncoder->encodePassword(
            $admin,
            'admin'
        ));

        $manager->persist($admin);
        $manager->flush();
    }
}
