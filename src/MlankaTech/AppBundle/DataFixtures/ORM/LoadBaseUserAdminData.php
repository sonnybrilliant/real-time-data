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
        $ronald->setEmail("ronald.conco@mlankatech.co.za");
        $ronald->setPassword($this->encodePassword($ronald,'654321'));
        $ronald->setStatus($this->getReference("status-active"));
        $ronald->setTitle($this->getReference("title-mr"));
        $ronald->setGender($this->getReference("gender-male"));
        $ronald->setGroup($this->getReference("group-super-admin"));
        $userManager->create($ronald);

        $sammy = new User();
        $sammy->setFirstName("Brian");
        $sammy->setLastName("Sebe");
        $sammy->setEmail("bsebe@prasa.com ");
        $sammy->setPassword($this->encodePassword($sammy,'654321'));
        $sammy->setStatus($this->getReference("status-active"));
        $sammy->setTitle($this->getReference("title-mr"));
        $sammy->setGender($this->getReference("gender-male"));
        $sammy->setGroup($this->getReference("group-super-admin"));
        $userManager->create($sammy);

        $ben = new User();
        $ben->setFirstName("Sekhuthe");
        $ben->setLastName("Makole");
        $ben->setEmail("smakole@prasa.com");
        $ben->setPassword($this->encodePassword($ben,'654321'));
        $ben->setStatus($this->getReference("status-active"));
        $ben->setTitle($this->getReference("title-mr"));
        $ben->setGender($this->getReference("gender-male"));
        $ben->setGroup($this->getReference("group-super-admin"));
        $userManager->create($ben);

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
