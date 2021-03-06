<?php

namespace MlankaTech\AppBundle\Services\Core;

use Doctrine\ORM\EntityManager;
use Monolog\Logger;
use JMS\DiExtraBundle\Annotation as DI;

/**
 * MlankaTech\AppBundle\Services\Core\MotorCoachTypeManager.
 *
 * @DI\Service("motor.coach.type.manager")
 *
 * @author Mfana Ronald Conco <ronald.conco@mlankatech.co.za>
 * @package MlankaTechAppBundle
 * @subpackage Services/Core
 * @version 0.0.1
 */
class MotorCoachTypeManager
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
     * Class construct.
     *
     * @param EntityManager $em
     * @param Logger        $logger
     *
     *
     * @DI\InjectParams({
     *     "em"          = @DI\Inject("doctrine.orm.entity_manager"),
     *     "logger"      = @DI\Inject("logger"),
     * })
     */
    public function __construct(EntityManager $em, Logger $logger)
    {
        $this->em = $em;
        $this->logger = $logger;

        return $this;
    }


    /**
     * Get query list of all motor coach types
     *
     * @param array $options
     * @return Query
     */
    public function getListAll($options = array())
    {
        $this->logger->info("Service MotorCoachTypeManager getListAll()");

        return $this->em->getRepository('MlankaTechAppBundle:MotorCoachType')
            ->getAllQueryList($options);

    }


}
