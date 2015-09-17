<?php

namespace MlankaTech\AppBundle\DataFixtures\ORM;


use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\Doctrine;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use MlankaTech\AppBundle\Entity\Role;

/**
 * LoadBaseRoleData
 *
 * -Create base data to be loaded before the application starts
 *
 * @author  Mfana Ronald Conco <ronald.conco@mlankatech.co.za>
 * @package MlankaTechAppBundle
 * @subpackage DataFixtures/ORM
 * @version 0.0.1
 */
class LoadBaseRoleData extends AbstractFixture implements OrderedFixtureInterface
{

    /**
     * Load data fixtures with the passed EntityManager
     *
     * @param \Doctrine\Common\Persistence\ObjectManager $manager
     * @return void
     */
    function load(ObjectManager $manager)
    {
        /**
         * User Roles
         */
        $admin = new Role("Super admin role","ROLE_ADMIN") ;
        $manager->persist($admin) ;

        $switchRole = new Role("Allow role switching","ROLE_ALLOWED_TO_SWITCH") ;
        $manager->persist($switchRole) ;

        /**
         * Train dashboard
         */
        $trainDashboard = new Role("Allow access to train dashboard","ROLE_TRAIN_DASHBOARD") ;
        $manager->persist($trainDashboard);
        /**
         * Train roles
         */
        $trainList = new Role("Allow access to train list","ROLE_TRAIN_LIST") ;
        $manager->persist($trainList);

        $trainProfile = new Role("Allow access to train profile","ROLE_TRAIN_PROFILE") ;
        $manager->persist($trainProfile);

        $trainCreate = new Role("Allow access to train create","ROLE_TRAIN_CREATE") ;
        $manager->persist($trainCreate);

        $trainEdit = new Role("Allow access to train edit","ROLE_TRAIN_EDIT") ;
        $manager->persist($trainEdit);

        $trainRemove = new Role("Allow access to train remove","ROLE_TRAIN_REMOVE") ;
        $manager->persist($trainRemove);

        $trainMonitor = new Role("Allow train view","ROLE_TRAIN_MONITOR") ;
        $manager->persist($trainMonitor);

        /**
         * User roles
         */
        $userList = new Role("Allow access to user list","ROLE_USER_LIST") ;
        $manager->persist($userList);

        $userCreate = new Role("Allow access to user create","ROLE_USER_CREATE") ;
        $manager->persist($userCreate);

        $userProfile = new Role("Allow access to user profile","ROLE_USER_PROFILE") ;
        $manager->persist($userProfile);

        $userEdit = new Role("Allow access to user edit","ROLE_USER_EDIT") ;
        $manager->persist($userEdit);

        $userRemove = new Role("Allow access to user remove","ROLE_USER_REMOVE") ;
        $manager->persist($userRemove);

        /**
         * MotorCoach Monitor
         */

        $motorCoachList = new Role("Allow motor coach list","ROLE_MOTOR_COACH_LIST") ;
        $manager->persist($motorCoachList);

        $motorCoachCreate = new Role("Allow motor coach create","ROLE_MOTOR_COACH_CREATE") ;
        $manager->persist($motorCoachCreate);

        $motorCoachEdit = new Role("Allow motor coach edit","ROLE_MOTOR_COACH_EDIT") ;
        $manager->persist($motorCoachEdit);

        $motorCoachRemove = new Role("Allow motor coach remove","ROLE_MOTOR_COACH_REMOVE") ;
        $manager->persist($motorCoachRemove);

        $motorCoachProfile = new Role("Allow motor coach profile","ROLE_MOTOR_COACH_PROFILE") ;
        $manager->persist($motorCoachProfile);

        $motorCoachMonitor = new Role("Allow motor coach monitor","ROLE_MOTOR_COACH_MONITOR") ;
        $manager->persist($motorCoachMonitor);




        $manager->flush() ;

        $this->addReference('role-admin' , $admin) ;
        $this->addReference('role-switch' , $switchRole) ;

        $this->addReference('role-train-dashboard' , $trainDashboard) ;
        $this->addReference('role-train-list' , $trainList) ;
        $this->addReference('role-train-create' , $trainCreate) ;
        $this->addReference('role-train-edit' , $trainEdit) ;
        $this->addReference('role-train-remove' , $trainRemove) ;
        $this->addReference('role-train-profile' , $trainProfile) ;
        $this->addReference('role-train-monitor' , $trainMonitor) ;

        $this->addReference('role-user-list' , $userList);
        $this->addReference('role-user-create' , $userCreate);
        $this->addReference('role-user-edit' , $userEdit);
        $this->addReference('role-user-remove' , $userRemove);
        $this->addReference('role-user-profile' , $userProfile);


        $this->addReference('role-motor-coach-list' , $motorCoachList) ;
        $this->addReference('role-motor-coach-create' , $motorCoachCreate) ;
        $this->addReference('role-motor-coach-edit' , $motorCoachEdit) ;
        $this->addReference('role-motor-coach-remove' , $motorCoachRemove) ;
        $this->addReference('role-motor-coach-profile' , $motorCoachProfile) ;
        $this->addReference('role-motor-coach-monitor' , $motorCoachMonitor) ;

    }

    /**
     * Get the order of this fixture
     *
     * @return integer
     */
    function getOrder()
    {
        return 1;
    }


}