<?php

namespace MlankaTech\AppBundle\DataFixtures\ORM;


use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\Doctrine;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use MlankaTech\AppBundle\Entity\MotorCoachType;

/**
 * LoadMotorCoachTypesData
 *
 * -Create base data to be loaded before the application starts
 *
 * @author  Mfana Ronald Conco <ronald.conco@mlankatech.co.za>
 * @package MlankaTechAppBundle
 * @subpackage DataFixtures/ORM
 * @version 0.0.1
 */
class LoadMotorCoachTypesData extends AbstractFixture implements OrderedFixtureInterface
{

    /**
     * Load data fixtures with the passed EntityManager
     *
     * @param \Doctrine\Common\Persistence\ObjectManager $manager
     * @return void
     */
    function load(ObjectManager $manager)
    {
        $motorCoach5M2A = new MotorCoachType("5M2A");
        $manager->persist($motorCoach5M2A);

        $motorCoach10M4S0 = new MotorCoachType("10M4S0");
        $manager->persist($motorCoach10M4S0);

        $motorCoach10M4S1 = new MotorCoachType("10M4S1");
        $manager->persist($motorCoach10M4S1);

        $motorCoach10M4S2 = new MotorCoachType("10M4S2");
        $manager->persist($motorCoach10M4S2);

        $motorCoach10MS3 = new MotorCoachType("10MS3");
        $manager->persist($motorCoach10MS3);

        $motorCoach10MS4 = new MotorCoachType("10MS4");
        $manager->persist($motorCoach10MS4);

        $motorCoach10M5 = new MotorCoachType("10M5");
        $manager->persist($motorCoach10M5);

        $motorCoach8M = new MotorCoachType("8M");
        $manager->persist($motorCoach8M);

        $motorCoach7M = new MotorCoachType("7M");
        $manager->persist($motorCoach7M);


        $motorCoach6M = new MotorCoachType("6M");
        $manager->persist($motorCoach6M);

        $manager->flush() ;

        $this->addReference('motor-coach-type-5M2A' , $motorCoach5M2A) ;
        $this->addReference('motor-coach-type-10M4S0' , $motorCoach10M4S0) ;
        $this->addReference('motor-coach-type-10M4S1' , $motorCoach10M4S1) ;
        $this->addReference('motor-coach-type-10M4S2' , $motorCoach10M4S2) ;
        $this->addReference('motor-coach-type-10MS3' , $motorCoach10MS3) ;
        $this->addReference('motor-coach-type-10MS4' , $motorCoach10MS4) ;
        $this->addReference('motor-coach-type-10M5' , $motorCoach10M5) ;
        $this->addReference('motor-coach-type-8M' , $motorCoach8M) ;
        $this->addReference('motor-coach-type-7M' , $motorCoach7M) ;
        $this->addReference('motor-coach-type-6M' , $motorCoach6M) ;
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