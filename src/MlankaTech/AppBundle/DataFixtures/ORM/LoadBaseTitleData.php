<?php

namespace MlankaTech\AppBundle\DataFixtures\ORM;


use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use MlankaTech\AppBundle\Entity\Title;

/**
 * LoadBaseTitleData
 *
 * -Create base data to be loaded before the application starts
 *
 * @author  Mfana Ronald Conco <ronald.conco@mlankatech.co.za>
 * @package MlankaTechAppBundle
 * @subpackage DataFixtures/ORM
 * @version 0.0.1
 */
class LoadBaseTitleData extends AbstractFixture implements OrderedFixtureInterface
{

    /**
     * Load data fixtures with the passed EntityManager
     *
     * @param \Doctrine\Common\Persistence\ObjectManager $manager
     * @return void
     */
    function load(ObjectManager $manager)
    {
        $mr = new Title('Mr') ;
        $manager->persist($mr) ;

        $mrs = new Title('Mrs') ;
        $manager->persist($mrs) ;

        $miss = new Title('Miss') ;
        $manager->persist($miss) ;

        $madam = new Title('Madam') ;
        $manager->persist($madam) ;

        $dr = new Title('Dr.') ;
        $manager->persist($dr) ;

        $prof = new Title('Prof.') ;
        $manager->persist($prof) ;

        $rev = new Title('Rev.') ;
        $manager->persist($rev) ;

        $manager->flush() ;

        $this->addReference('title-dr' , $dr) ;
        $this->addReference('title-madam' , $madam) ;
        $this->addReference('title-miss' , $miss) ;
        $this->addReference('title-mr' , $mr) ;
        $this->addReference('title-mrs' , $mrs) ;
        $this->addReference('title-prof' , $prof) ;
        $this->addReference('title-rev' , $rev) ;
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