<?php

namespace MlankaTech\AppBundle\Services\MotorCoach;

use Doctrine\ORM\EntityManager;
use MlankaTech\AppBundle\Entity\MotorCoach;
use JMS\DiExtraBundle\Annotation as DI;
use JMS\DiExtraBundle\Annotation\Inject;
use MlankaTech\AppBundle\Services\Core\StatusManager;
use MlankaTech\AppBundle\Services\Core\ConditionManager;
use Monolog\Logger;

/**
 * MotorCoachManager
 *
 * @DI\Service("motor.coach.manager")
 * @author  Mfana Ronald Conco <ronald.conco@mlankatech.co.za>
 * @package MlankaTechAppBundle
 * @subpackage Services
 * @version 0.0.1
 *
 */
class MotorCoachManager
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
     * @var Status manager
     */
    protected $sm;

    /**
     * @var Condition manager
     */
    protected $conditionManager;

    /**
     * Security Storage Token
     * @var object
     * @Inject("security.token_storage", required = false)
     */
    public $securityTokenStorage;

    /**
     *
     * Class construct
     *
     * @param EntityManager    $em
     * @param Logger           $logger
     * @param StatusManager    $sm
     * @param ConditionManager $conditionManager
     *
     * @DI\InjectParams({
     *     "em"                  = @DI\Inject("doctrine.orm.entity_manager"),
     *     "logger"              = @DI\Inject("logger"),
     *     "sm"                  = @DI\Inject("status.manager"),
     *     "conditionManager"    = @DI\Inject("condition.manager")
     * })
     */
    public function __construct(
        EntityManager $em,
        Logger $logger,
        StatusManager $sm,
        ConditionManager $conditionManager
    )
    {
        $this->em = $em;
        $this->logger = $logger;
        $this->sm = $sm;
        $this->conditionManager = $conditionManager;
    }

    /**
     * Get Current user
     *
     * @return MlankaTechAppBundle:User
     */
    public function getCurrentUser()
    {
       if($this->securityTokenStorage->getToken()){
           return $this->securityTokenStorage->getToken()->getUser();
       }
        return false;
    }

    /**
     * Get motor coach by id
     *
     * @param integer $id
     * @return MlankaTechAppBundle:MotorCoach
     */
    public function getById($id)
    {
        $this->logger->info("Service MotorCoachManager getById()");
        return $this->em->getRepository('MlankaTechAppBundle:MotorCoach')
            ->find($id);
    }

    /**
     * Get motor coach by Slug
     *
     * @param String $slug
     * @return MlankaTechAppBundle:MotorCoach
     */
    public function getBySlug($slug)
    {
        $this->logger->info("Service MotorCoachManager getBySlug()");
        return $this->em->getRepository('MlankaTechAppBundle:MotorCoach')
            ->findBySlug($slug);

    }

    /**
     * Get query list of all motor coaches
     *
     * @param array $options
     * @return Query
     */
    public function getListAll($options = array())
    {
        $this->logger->info("Service MotorCoachManager getListAll()");

        return $this->em->getRepository('MlankaTechAppBundle:MotorCoach')
            ->getAllQueryList($options);

    }

    /**
     * Create motor coach
     *
     * @param MotorCoach $motorCoach
     * @return MotorCoach
     */
    public function create(\MlankaTech\AppBundle\Entity\MotorCoach $motorCoach)
    {
        $this->logger->info("Service MotorCoachManager create()");

        $motorCoach->setStatus($this->sm->notAllocated());
        $motorCoach->setCondition($this->conditionManager->unknown());

        if($this->getCurrentUser()){
            $motorCoach->setCreatedBy($this->getCurrentUser());
        }else{
            $motorCoach->setCreatedBy(NULL);
        }

        $this->em->persist($motorCoach);
        $this->em->flush();
        return $motorCoach;
    }

    /**
     * Update motor coach
     *
     * @param MotorCoach $motorCoach
     * @return MotorCoach
     */
    public function update(\MlankaTech\AppBundle\Entity\MotorCoach $motorCoach)
    {
        $this->logger->info("Service MotorCoachManager update()");

        $this->em->persist($motorCoach);
        $this->em->flush();
        return $motorCoach;
    }

}
