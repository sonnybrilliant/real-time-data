<?php

namespace MlankaTech\AppBundle\DataFixtures\ORM;


use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use MlankaTech\AppBundle\Entity\User;

/**
 * LoadBaseUserAdminData
 *
 * -Create base data to be loaded before the application starts
 *
 * @author  Mfana Ronald Conco <ronald.conco@mlankatech.co.za>
 * @package MlankaTechAppBundle
 * @subpackage DataFixtures/ORM
 * @version 0.0.1
 */
class LoadBaseUserAdminData extends AbstractFixture implements OrderedFixtureInterface,ContainerAwareInterface
{

    /**
     * @var ContainerInterface
     */
    private $container;

    /**
     * Sets the Container.
     *
     * @param ContainerInterface|null $container A ContainerInterface instance or null
     *
     * @api
     */
    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }


    /**
     * Load data fixtures with the passed EntityManager
     *
     * @param \Doctrine\Common\Persistence\ObjectManager $manager
     * @return void
     */
    function load(ObjectManager $manager)
    {
        $userManager  = $this->container->get('user.manager');
        $ronald = new User();
        $ronald->setFirstName("Mfana");
        $ronald->setLastName("Conco");
        $ronald->setEmail("admin@example.co.za");
        $ronald->setPassword($this->encodePassword($ronald,'qazxsw!'));
        $ronald->setStatus($this->getReference("status-active"));
        $ronald->setTitle($this->getReference("title-mr"));
        $ronald->setGender($this->getReference("gender-male"));
        $ronald->setGroup($this->getReference("group-super-admin"));
        $userManager->create($ronald);

        $sammy = new User();
        $sammy->setFirstName("Sammy");
        $sammy->setLastName("Junior");
        $sammy->setEmail("sammy@example.co.za");
        $sammy->setPassword($this->encodePassword($sammy,'qazxsw!'));
        $sammy->setStatus($this->getReference("status-active"));
        $sammy->setTitle($this->getReference("title-mr"));
        $sammy->setGender($this->getReference("gender-male"));
        $sammy->setGroup($this->getReference("group-super-admin"));
        $userManager->create($sammy);

        $ben = new User();
        $ben->setFirstName("Benjamin");
        $ben->setLastName("Dube");
        $ben->setEmail("ben@example.co.za");
        $ben->setPassword($this->encodePassword($ben,'qazxsw!'));
        $ben->setStatus($this->getReference("status-active"));
        $ben->setTitle($this->getReference("title-mr"));
        $ben->setGender($this->getReference("gender-male"));
        $ben->setGroup($this->getReference("group-super-admin"));
        $userManager->create($ben);

        $dave = new User();
        $dave->setFirstName("Dave");
        $dave->setLastName("Dube");
        $dave->setEmail("dave@example.co.za");
        $dave->setPassword($this->encodePassword($dave,'qazxsw!'));
        $dave->setStatus($this->getReference("status-active"));
        $dave->setTitle($this->getReference("title-mr"));
        $dave->setGender($this->getReference("gender-male"));
        $dave->setGroup($this->getReference("group-super-admin"));
        $userManager->create($dave);

        $brilliant = new User();
        $brilliant->setFirstName("Sonny");
        $brilliant->setLastName("Brilliant");
        $brilliant->setEmail("sonny@example.co.za");
        $brilliant->setPassword($this->encodePassword($brilliant,'qazxsw!'));
        $brilliant->setStatus($this->getReference("status-active"));
        $brilliant->setTitle($this->getReference("title-mr"));
        $brilliant->setGender($this->getReference("gender-male"));
        $brilliant->setGroup($this->getReference("group-super-admin"));
        $userManager->create($brilliant);

        $tate = new User();
        $tate->setFirstName("Tate");
        $tate->setLastName("Brilliant");
        $tate->setEmail("tate@example.co.za");
        $tate->setPassword($this->encodePassword($tate,'qazxsw!'));
        $tate->setStatus($this->getReference("status-active"));
        $tate->setTitle($this->getReference("title-mr"));
        $tate->setGender($this->getReference("gender-male"));
        $tate->setGroup($this->getReference("group-super-admin"));
        $userManager->create($tate);

        $solly = new User();
        $solly->setFirstName("Solly");
        $solly->setLastName("Blue");
        $solly->setEmail("solly@example.co.za");
        $solly->setPassword($this->encodePassword($solly,'qazxsw!'));
        $solly->setStatus($this->getReference("status-active"));
        $solly->setTitle($this->getReference("title-mr"));
        $solly->setGender($this->getReference("gender-male"));
        $solly->setGroup($this->getReference("group-super-admin"));
        $userManager->create($solly);

        $nancy = new User();
        $nancy->setFirstName("Nancy");
        $nancy->setLastName("Bluben");
        $nancy->setEmail("nancy@example.co.za");
        $nancy->setPassword($this->encodePassword($nancy,'qazxsw!'));
        $nancy->setStatus($this->getReference("status-active"));
        $nancy->setTitle($this->getReference("title-mr"));
        $nancy->setGender($this->getReference("gender-male"));
        $nancy->setGroup($this->getReference("group-super-admin"));
        $userManager->create($nancy);

        $rati = new User();
        $rati->setFirstName("Reratilwe");
        $rati->setLastName("Maboea");
        $rati->setEmail("rati@example.co.za");
        $rati->setPassword($this->encodePassword($rati,'qazxsw!'));
        $rati->setStatus($this->getReference("status-active"));
        $rati->setTitle($this->getReference("title-mr"));
        $rati->setGender($this->getReference("gender-male"));
        $rati->setGroup($this->getReference("group-super-admin"));
        $userManager->create($rati);

        $vanessa = new User();
        $vanessa->setFirstName("Vanessa");
        $vanessa->setLastName("Conco");
        $vanessa->setEmail("vanessa@example.co.za");
        $vanessa->setPassword($this->encodePassword($vanessa,'qazxsw!'));
        $vanessa->setStatus($this->getReference("status-active"));
        $vanessa->setTitle($this->getReference("title-mr"));
        $vanessa->setGender($this->getReference("gender-male"));
        $vanessa->setGroup($this->getReference("group-super-admin"));
        $userManager->create($vanessa);

        $bruce = new User();
        $bruce->setFirstName("Bruce");
        $bruce->setLastName("Lifa");
        $bruce->setEmail("bruce@example.co.za");
        $bruce->setPassword($this->encodePassword($bruce,'qazxsw!'));
        $bruce->setStatus($this->getReference("status-active"));
        $bruce->setTitle($this->getReference("title-mr"));
        $bruce->setGender($this->getReference("gender-male"));
        $bruce->setGroup($this->getReference("group-super-admin"));
        $userManager->create($bruce);



        $this->addReference('admin-ronald' , $ronald) ;

    }

    private function encodePassword(User $user, $plainPassword)
    {
        $encoder = $this->container->get('security.encoder_factory')
            ->getEncoder($user);
        return $encoder->encodePassword($plainPassword,$user->getSalt());
    }

    /**
     * Get the order of this fixture
     *
     * @return integer
     */
    function getOrder()
    {
        return 4;
    }


}
