<?php

namespace MlankaTech\AppBundle\DataFixtures\ORM;


use Doctrine\Common\DataFixtures\AbstractFixture;
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
        $motorCoach5M = new MotorCoachType("5M");
        $motorCoach5M->setDescription('5M Model');
        $manager->persist($motorCoach5M);

        $motorCoach5M2A = new MotorCoachType("5M2A");
        $motorCoach5M2A->setDescription('5M2A Model');
        $manager->persist($motorCoach5M2A);

        $motorCoach6M = new MotorCoachType("6M");
        $motorCoach6M->setDescription('6M Model');
        $manager->persist($motorCoach6M);

        $motorCoach7M = new MotorCoachType("7M");
        $motorCoach7M->setDescription('7M Model');
        $manager->persist($motorCoach7M);

        $motorCoach8M = new MotorCoachType("8M");
        $motorCoach8M->setDescription('8M Model');
        $manager->persist($motorCoach8M);

        $motorCoach10M4S0 = new MotorCoachType("10M4S0");
        $motorCoach10M4S0->setDescription('10M4S0 Model');
        $manager->persist($motorCoach10M4S0);

        $motorCoach10M4S1 = new MotorCoachType("10M4S1");
        $motorCoach10M4S1->setDescription('10M4S1 Model');
        $manager->persist($motorCoach10M4S1);

        $motorCoach10M4S2 = new MotorCoachType("10M4S2");
        $motorCoach10M4S2->setDescription('10M4S2 Model');
        $manager->persist($motorCoach10M4S2);

        $motorCoach10MS3 = new MotorCoachType("10MS3");
        $motorCoach10MS3->setDescription('10MS3 Model');
        $manager->persist($motorCoach10MS3);

        $motorCoach10MS4 = new MotorCoachType("10MS4");
        $motorCoach10MS4->setDescription('10MS4 Model');
        $manager->persist($motorCoach10MS4);

        $motorCoach10M5 = new MotorCoachType("10M5");
        $motorCoach10M5->setDescription('10M5 Model');
        $manager->persist($motorCoach10M5);








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