<?php

namespace MlankaTech\AppBundle\Services\Core;

use Doctrine\ORM\EntityManager;
use Monolog\Logger;
use JMS\DiExtraBundle\Annotation as DI;

/**
 * StatusManager
 *
 * @DI\Service("status.manager")
 * @author Mfana Ronald Conco <ronald.conco@mlankatech.co.za>
 * @package MlankaTechAppBundle
 * @subpackage Services
 * @version 0.0.1
 *
 */
class StatusManager
{
    /**
     * @var Monolog logger
     */
    protected $logger;

    /**
     * @var Entity manager
     */
    protected $em;

    /**
     * Class construct
     *
     * @param EntityManager   $em
     * @param Logger          $logger
     *
     *
     * @DI\InjectParams({
     *     "em"          = @DI\Inject("doctrine.orm.entity_manager"),
     *     "logger"      = @DI\Inject("logger"),
     * })
     */
    public function __construct(EntityManager $em,Logger $logger)
    {
        $this->em = $em;
        $this->logger = $logger;

        return $this;
    }

    /**
     * Get status by name
     *
     * @param String $statusName
     * @return MlankaTechAppBundle:Status
     * @throws \Exception
     */
    public function getStatusByName($statusName)
    {
        $this->logger->info('Service StatusManager getStatusByName()');

        $status = $this->em
            ->getRepository('MlankaTechAppBundle:Status')
            ->getStatus($statusName);

        if (!$status) {
            $this->logger->debug('Status.Manager getStatusByName()' . $statusName . ' status');
            throw new \Exception('Exception, no ' . $statusName . ' status found');
        }

        return $status;
    }

    /**
     * get active status
     * @return MlankaTechAppBundle:Status
     */
    public function active()
    {
        $this->logger->info('Service StatusManager active()');
        return $this->getStatusByName('Active');
    }

    /**
     * get suspended status.
     *
     * @return MlankaTechAppBundle:Status
     */
    public function suspended()
    {
        $this->logger->info('Service StatusManager suspended()');

        return $this->getStatusByName('Suspended');
    }

    /**
     * get lock status
     * @return MlankaTechAppBundle:Status
     */
    public function locked()
    {
        $this->logger->info('Service StatusManager locked()');
        return $this->getStatusByName('Locked');
    }

    /**
     * get expired status
     * @return MlankaTechAppBundle:Status
     */
    public function expired()
    {
        $this->logger->info('Service StatusManager expired()');
        return $this->getStatusByName('Expired');
    }

    /**
     * get delete status
     * @return MlankaTechAppBundle:Status
     */
    public function deleted()
    {
        $this->logger->info('Service StatusManager deleted()');
        return $this->getStatusByName('Deleted');
    }

    /**
     * get approved status
     * @return MlankaTechAppBundle:Status
     */
    public function approved()
    {
        $this->logger->info('Service StatusManager approve()');
        return $this->getStatusByName('Approved');
    }

    /**
     * get rejected status
     * @return MlankaTechAppBundle:Status
     */
    public function rejected()
    {
        $this->logger->info('Service StatusManager reject()');
        return $this->getStatusByName('Rejected');
    }

    /**
     * get pending status
     * @return MlankaTechAppBundle:Status
     */
    public function pending()
    {
        $this->logger->info('Service StatusManager pending()');
        return $this->getStatusByName('Pending');
    }

    /**
     * get online status
     * @return MlankaTechAppBundle:Status
     */
    public function online()
    {
        $this->logger->info('Service StatusManager online()');
        return $this->getStatusByName('Online');
    }

    /**
     * get offline status
     * @return MlankaTechAppBundle:Status
     */
    public function offline()
    {
        $this->logger->info('Service StatusManager offline()');
        return $this->getStatusByName('Offline');
    }
}
