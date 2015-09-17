<?php

namespace MlankaTech\AppBundle\DataFixtures\ORM;


use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\Doctrine;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use MlankaTech\AppBundle\Entity\Gender;

/**
 * LoadBaseGenderData
 *
 * -Create base data to be loaded before the application starts
 *
 * @author  Mfana Ronald Conco <ronald.conco@mlankatech.co.za>
 * @package MlankaTechAppBundle
 * @subpackage DataFixtures/ORM
 * @version 0.0.1
 */
class LoadBaseGenderData extends AbstractFixture implements OrderedFixtureInterface
{

    /**
     * Load data fixtures with the passed EntityManager
     *
     * @param \Doctrine\Common\Persistence\ObjectManager $manager
     * @return void
     */
    function load(ObjectManager $manager)
    {
        $male = new Gender("Male");
        $manager->persist($male);

        $female = new Gender("Female");
        $manager->persist($female);

        $manager->flush() ;

        $this->addReference('gender-male' , $male) ;
        $this->addReference('gender-female' , $female) ;
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