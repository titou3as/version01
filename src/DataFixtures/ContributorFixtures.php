<?php


namespace App\DataFixtures;


use App\Entity\Contributor;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class ContributorFixtures extends Fixture
{
    private $firstname = ['Paskin','Fring','Nenad','Sun'];
    private $lastname = ['Norman','Andrias','Manojlovic','Huh'];
    private $email = ['paskin.nikolas@doi.org','afring@city.ac.uk','nmanoj@ualg.pt','shuh@hallym.ac.kr'];
    private $username = ['con123','con456','con789',''];
    private $password = ['0000','1111','2222','3333'];
    /**
     * Load data fixtures with the passed EntityManager
     *
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        /**
         * Insert 5 new Contributors To the Contributor Table
         */
        for ($i = 0; $i < 4; $i++) {
            /**
             * @var Contributor $contributor
             */
            $contributor = new Contributor();
            $contributor->setFirstname($this->firstname[$i])
                ->setLastname($this->lastname[$i])
                ->setEmail($this->email[$i])
                ->setUsername($this->username[$i])
                ->setPassword($this->password[$i])
            ->setIsAdmin(false);
            $manager->persist($contributor);
        }
        $manager->flush();
    }
}