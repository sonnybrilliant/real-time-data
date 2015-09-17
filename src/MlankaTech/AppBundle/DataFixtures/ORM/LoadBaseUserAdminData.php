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
        $ronald = new User();
        $ronald->setFirstName("Mfana");
        $ronald->setLastName("Conco");
        $ronald->setEmail("admin@example.co.za");
        $ronald->setPassword($this->encodePassword($ronald,'qazxsw!'));
        $ronald->setStatus($this->getReference("status-active"));
        $ronald->setTitle($this->getReference("title-mr"));
        $ronald->setGender($this->getReference("gender-male"));
        $ronald->setGroup($this->getReference("group-super-admin"));

        $manager->persist($ronald);
        $manager->flush();

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
