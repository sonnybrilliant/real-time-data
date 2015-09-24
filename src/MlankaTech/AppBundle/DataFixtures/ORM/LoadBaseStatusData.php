<?php

namespace MlankaTech\AppBundle\DataFixtures\ORM;


use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use MlankaTech\AppBundle\Entity\Status;

/**
 * LoadBaseStatusData
 *
 * -Create base data to be loaded before the application starts
 *
 * @author  Mfana Ronald Conco <ronald.conco@mlankatech.co.za>
 * @package MlankaTechAppBundle
 * @subpackage DataFixtures/ORM
 * @version 0.0.1
 */
class LoadBaseStatusData extends AbstractFixture implements OrderedFixtureInterface
{

    /**
     * Load data fixtures with the passed EntityManager
     *
     * @param \Doctrine\Common\Persistence\ObjectManager $manager
     * @return void
     */
    function load(ObjectManager $manager)
    {
        $active = new Status("Active",1);
        $manager->persist($active);

        $inactive = new Status("Inactive",2);
        $manager->persist($inactive);

        $disabled = new Status("Disabled",3);
        $manager->persist($disabled);

        $blocked = new Status("Blocked",4);
        $manager->persist($blocked);

        $completed = new Status("Completed",5);
        $manager->persist($completed);

        $cancelled = new Status("Cancelled",6);
        $manager->persist($cancelled);

        $deleted = new Status("Deleted",7);
        $manager->persist($deleted);

        $locked = new Status("Locked",8);
        $manager->persist($locked);

        $approved = new Status("Approved",9);
        $manager->persist($approved);

        $rejected = new Status("Rejected",10);
        $manager->persist($rejected);

        $expired = new Status("Expired",11);
        $manager->persist($expired);

        $new = new Status("New",30);
        $manager->persist($new);

        $old = new Status("Old",40);
        $manager->persist($old);

        $progress = new Status("In Progress",70);
        $manager->persist($progress);

        $pending = new Status("Pending",80);
        $manager->persist($pending);

        $pendingEncoding = new Status("Encoding",100);
        $manager->persist($pendingEncoding);

        $error = new Status("Error",120);
        $manager->persist($error);

        $failed = new Status("Failed",130);
        $manager->persist($failed);

        $objSuccess = new Status("Successful",140);
        $manager->persist($objSuccess);

        $timeout = new Status("Timed out",150);
        $manager->persist($timeout);

        $inviteSent = new Status("Invite sent",170);
        $manager->persist($inviteSent);

        $queued = new Status("Queued",240);
        $manager->persist($queued);

        $submitted = new Status("Submitted",250);
        $manager->persist($submitted);

        $acknowledged = new Status("Acknowledged",260);
        $manager->persist($acknowledged);

        $receipted = new Status("Receipted",270);
        $manager->persist($receipted);

        $running = new Status("Running",280);
        $manager->persist($running);

        $speeding = new Status("Speeding",290);
        $manager->persist($speeding);

        $service = new Status("Service",300);
        $manager->persist($service);

        $stationary = new Status("Stationary",310);
        $manager->persist($stationary);

        $online = new Status("Online",320);
        $manager->persist($online);

        $offline = new Status("Offline",330);
        $manager->persist($offline);

        $suspended = new Status('Suspended', 340);
        $manager->persist($suspended);

        $manager->flush();

        $this->addReference('status-active', $active);
        $this->addReference('status-service', $service);
        $this->addReference('status-speeding', $speeding);
        $this->addReference('status-offline',$offline);
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