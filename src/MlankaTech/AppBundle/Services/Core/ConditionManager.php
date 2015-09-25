<?php

namespace MlankaTech\AppBundle\Services\Core;

use Doctrine\ORM\EntityManager;
use Monolog\Logger;
use JMS\DiExtraBundle\Annotation as DI;

/**
 * ConditionManager
 *
 * @DI\Service("condition.manager")
 * @author Mfana Ronald Conco <ronald.conco@mlankatech.co.za>
 * @package MlankaTechAppBundle
 * @subpackage Services/Core
 * @version 0.0.1
 *
 */
class ConditionManager
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
     * Get condition by name
     *
     * @param String $conditionName
     * @return MlankaTechAppBundle:Condition
     * @throws \Exception
     */
    public function getConditionByName($conditionName)
    {
        $this->logger->info('Service ConditionManager getConditionByName()');

        $status = $this->em
            ->getRepository('MlankaTechAppBundle:Condition')
            ->getCondition($conditionName);

        if (!$status) {
            $this->logger->debug('Service ConditionManager getConditionByName' . $conditionName . ' condition');
            throw new \Exception('Exception, no ' . $conditionName . ' condition found');
        }

        return $status;
    }

    /**
     * get unknown condition
     * @return MlankaTechAppBundle:Condition
     */
    public function unknown()
    {
        $this->logger->info('Service ConditionManager  unknown()');
        return $this->getConditionByName('unknown');
    }

    /**
     * get critical condition
     * @return MlankaTechAppBundle:Condition
     */
    public function critical()
    {
        $this->logger->info('Service ConditionManager  critical()');
        return $this->getConditionByName('critical');
    }

    /**
     * get warning condition
     * @return MlankaTechAppBundle:Condition
     */
    public function warning()
    {
        $this->logger->info('Service ConditionManager  warning()');
        return $this->getConditionByName('warning');
    }

    /**
     * get good condition
     * @return MlankaTechAppBundle:Condition
     */
    public function good()
    {
        $this->logger->info('Service ConditionManager  good()');
        return $this->getConditionByName('good');
    }

    /**
     * get excellent condition
     * @return MlankaTechAppBundle:Condition
     */
    public function excellent()
    {
        $this->logger->info('Service ConditionManager  excellent()');
        return $this->getConditionByName('excellent');
    }
}
