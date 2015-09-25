<?php

namespace MlankaTech\AppBundle\DataFixtures\ORM;


use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use MlankaTech\AppBundle\Entity\TrainType;

/**
 * LoadTrainTypesData
 *
 * -Create base data to be loaded before the application starts
 *
 * @author  Mfana Ronald Conco <ronald.conco@mlankatech.co.za>
 * @package MlankaTechAppBundle
 * @subpackage DataFixtures/ORM
 * @version 0.0.1
 */
class LoadTrainTypesData extends AbstractFixture implements OrderedFixtureInterface
{

    /**
     * Load data fixtures with the passed EntityManager
     *
     * @param \Doctrine\Common\Persistence\ObjectManager $manager
     * @return void
     */
    function load(ObjectManager $manager)
    {
        $trainMetro = new TrainType("metro");
        $trainMetro->setDescription('City to city bound');
        $manager->persist($trainMetro);

        $trainMetroPlus = new TrainType("metro plus");
        $trainMetroPlus->setDescription('City to city bound');
        $manager->persist($trainMetroPlus);

        $trainBusinessExpress = new TrainType("business express");
        $trainBusinessExpress->setDescription('City to city bound');
        $manager->persist($trainBusinessExpress);


        $manager->flush() ;

        $this->addReference('train-type-metro' , $trainMetro) ;
        $this->addReference('train-type-metro-plus' , $trainMetroPlus) ;
        $this->addReference('train-type-business-express' , $trainBusinessExpress) ;
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