<?php

namespace App\DataFixtures;

use App\Entity\User;
use App\Entity\UserType\Agent;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Faker\Generator;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

/**
 * Class UserFixtures
 * @package App\DataFixtures
 */
class UserFixtures extends Fixture
{
    /**
     * @var UserPasswordEncoderInterface
     */
    private $encoder;

    /**
     * @var Generator
     */
    private $faker;

    /**
     * UserFixtures constructor.
     * @param UserPasswordEncoderInterface $encoder
     */
    public function __construct(
        UserPasswordEncoderInterface $encoder
    )
    {
        $this->encoder = $encoder;
        $this->faker   = Factory::create();
    }

    /**
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        $adminData = require __DIR__ . './../../fixtures_data/user/admins.php';

        foreach ($adminData as $data) {
            $user = (new User())
                ->setEmail($data['email'])
                ->setFirstName($data['firstName'])
                ->setLastName($data['lastName'])
                ->setRoles($data['roles'])
                ->setLastSeen($data['lastSeen']);

            $agent = (new Agent())
                ->setName($data['agent_info']['name'])
                ->setSurname($data['agent_info']['surname'])
                ->setAge($data['agent_info']['age'])
                ->setDescription($data['agent_info']['description'])
                ->setCountry($data['agent_info']['country'])
                ->setCity($data['agent_info']['city'])
                ->setAddressOne($data['agent_info']['addressOne'])
                ->setAddressTwo($data['agent_info']['addressTwo'])
                ->setUser($user);

            $pass = $this->encoder->encodePassword($user, $data['password']);
            $user->setPassword($pass);
            $user->setAgent($agent);

            $this->addReference(self::name() . $user->getEmail(), $user);

            $manager->persist($user);
        }

        for ($i = 0; $i < 50; $i++) {
            $date = $this->faker->dateTimeBetween('-1 years', '-10 days');
            $user = (new User())
                ->setEmail($this->faker->email)
                ->setFirstName($this->faker->firstName)
                ->setLastName($this->faker->lastName)
                ->setRoles(['ROLE_USER'])
                ->setLastSeen($date->modify('+5 days'));

            $agent = (new Agent())
                ->setName($this->faker->firstName)
                ->setSurname($this->faker->lastName)
                ->setAge($this->faker->numberBetween(18, 60))
                ->setDescription($this->faker->realText())
                ->setCountry($this->faker->country)
                ->setCity($this->faker->city)
                ->setAddressOne($this->faker->address)
                ->setAddressTwo($this->faker->secondaryAddress)
                ->setUser($user);

            $pass = $this->encoder->encodePassword($user, '123456');
            $user->setPassword($pass);
            $user->setAgent($agent);

            $this->addReference(self::name() . $user->getEmail(), $user);

            $manager->persist($user);
        }

        for ($i = 0; $i < 15; $i++) {
            $date = $this->faker->dateTimeBetween('-1 years', '-10 days');
            $user = (new User())
                ->setEmail($this->faker->email)
                ->setFirstName($this->faker->firstName)
                ->setLastName($this->faker->lastName)
                ->setRoles(['ROLE_AGENT'])
                ->setLastSeen($date->modify('+5 days'));

            $pass = $this->encoder->encodePassword($user, '123456');
            $user->setPassword($pass);

            $this->addReference(self::name() . $user->getEmail(), $user);

            $manager->persist($user);
        }

        $manager->flush();
    }

    /**
     * @return string
     */
    static public function name()
    {
        return self::class;
    }
}