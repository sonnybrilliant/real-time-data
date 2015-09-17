<?php

namespace MlankaTech\AppBundle\DataFixtures\ORM;


use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\Doctrine;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use MlankaTech\AppBundle\Entity\UserGroup;

/**
 * LoadBaseUserGroupData
 *
 * -Create base data to be loaded before the application starts
 *
 * @author  Mfana Ronald Conco <ronald.conco@mlankatech.co.za>
 * @package MlankaTechAppBundle
 * @subpackage DataFixtures/ORM
 * @version 0.0.1
 */
class LoadBaseUserGroupData extends AbstractFixture implements OrderedFixtureInterface
{

    /**
     * Load data fixtures with the passed EntityManager
     *
     * @param \Doctrine\Common\Persistence\ObjectManager $manager
     * @return void
     */
    function load(ObjectManager $manager)
    {

        $superAdmin = new UserGroup('Super administrator');
        $superAdmin->addRole($this->getReference('role-admin'));
        $superAdmin->addRole($this->getReference('role-switch'));
        $superAdmin->addRole($this->getReference('role-train-dashboard'));
        $superAdmin->addRole($this->getReference('role-train-list'));
        $superAdmin->addRole($this->getReference('role-train-create'));
        $superAdmin->addRole($this->getReference('role-train-edit'));
        $superAdmin->addRole($this->getReference('role-train-remove'));
        $superAdmin->addRole($this->getReference('role-train-profile'));
        $superAdmin->addRole($this->getReference('role-train-monitor'));
        $superAdmin->addRole($this->getReference('role-user-list'));
        $superAdmin->addRole($this->getReference('role-user-create'));
        $superAdmin->addRole($this->getReference('role-user-edit'));
        $superAdmin->addRole($this->getReference('role-user-remove'));
        $superAdmin->addRole($this->getReference('role-user-profile'));
        $superAdmin->addRole($this->getReference('role-motor-coach-list'));
        $superAdmin->addRole($this->getReference('role-motor-coach-create'));
        $superAdmin->addRole($this->getReference('role-motor-coach-edit'));
        $superAdmin->addRole($this->getReference('role-motor-coach-remove'));
        $superAdmin->addRole($this->getReference('role-motor-coach-monitor'));
        $manager->persist($superAdmin) ;

        $manager->flush() ;

        $this->addReference('group-super-admin' , $superAdmin) ;
    }

    /**
     * Get the order of this fixture
     *
     * @return integer
     */
    function getOrder()
    {
        return 2;
    }


}