<?php

namespace MlankaTech\AppBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use MlankaTech\AppBundle\Entity\Condition;

/**
 * LoadBaseConditionData
 *
 * -Create base data to be loaded before the application starts
 *
 * @author  Mfana Ronald Conco <ronald.conco@mlankatech.co.za>
 * @package MlankaTechAppBundle
 * @subpackage DataFixtures/ORM
 * @version 0.0.1
 */
class LoadBaseConditionData extends AbstractFixture implements OrderedFixtureInterface
{

    /**
     * Load data fixtures with the passed EntityManager
     *
     * @param \Doctrine\Common\Persistence\ObjectManager $manager
     * @return void
     */
    function load(ObjectManager $manager)
    {
        $unknown = new Condition("unknown","label-default");
        $manager->persist($unknown);

        $critical = new Condition("critical","label-danger");
        $manager->persist($critical);

        $warning = new Condition("warning","label-warning");
        $manager->persist($warning );

        $good = new Condition("good","label-success");
        $manager->persist($good);

        $excellent = new Condition("excellent","label-primary");
        $manager->persist($excellent);


        $manager->flush();

        $this->addReference('condition-critical', $critical);
        $this->addReference('condition-warning', $warning);
        $this->addReference('condition-good', $good);
        $this->addReference('condition-excellent', $excellent);
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