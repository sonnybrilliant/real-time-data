<?php

namespace MlankaTech\AppBundle\Services\MotorCoach;

use Doctrine\ORM\EntityManager;
use JMS\DiExtraBundle\Annotation as DI;
use Monolog\Logger;

/**
 * MotorCoachTransactionManager
 *
 * @DI\Service("motor.coach.transaction.manager")
 * @author  Mfana Ronald Conco <ronald.conco@mlankatech.co.za>
 * @package MlankaTechAppBundle
 * @subpackage Services
 * @version 0.0.1
 *
 */
class MotorCoachTransactionManager
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
     *
     * Class construct
     *
     * @param EntityManager     $em
     * @param Logger            $logger
     *
     * @DI\InjectParams({
     *     "em"                  = @DI\Inject("doctrine.orm.entity_manager"),
     *     "logger"              = @DI\Inject("logger")
     * })
     */
    public function __construct(
        EntityManager $em,
        Logger $logger
    )
    {
        $this->em = $em;
        $this->logger = $logger;

    }

    /**
     * Get motor coach transaction by id
     *
     * @param integer $id
     * @return MlankaTechAppBundle:MotorCoachTransaction
     */
    public function getById($id)
    {
        $this->logger->info("Service MotorCoachTransactionManager getById()");
        return $this->em->getRepository('MlankaTechAppBundle:MotorCoachTransaction')
            ->find($id);
    }

    /**
     * Get motor coach transactions by motor coach
     * @param int $motorCoach
     * @param int $limit
     *
     * @return array
     */
    public function getByMotorCoach($motorCoach, $limit = 5)
    {
        $this->logger->info("Service MotorCoachTransactionManager getByMotorCoach()");
        return $this->em->getRepository('MlankaTechAppBundle:MotorCoachTransaction')
            ->getByMotorCoach($motorCoach,$limit);
    }

    public function getRecentTransactionPerMotorCoach()
    {
        $this->logger->info("Service MotorCoachTransactionManager getRecentTransactionPerMotorCoach()");

        return $this->em->getRepository('MlankaTechAppBundle:MotorCoachTransaction')
            ->getLatestPerTrain();
    }
}
