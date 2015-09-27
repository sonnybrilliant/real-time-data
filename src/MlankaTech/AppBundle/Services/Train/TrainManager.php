<?php

namespace MlankaTech\AppBundle\Services\Train;

use Doctrine\ORM\EntityManager;
use MlankaTech\AppBundle\Entity\MotorCoach;
use JMS\DiExtraBundle\Annotation as DI;
use JMS\DiExtraBundle\Annotation\Inject;
use MlankaTech\AppBundle\Services\Core\StatusManager;
use MlankaTech\AppBundle\Services\Core\ConditionManager;
use MlankaTech\AppBundle\Event\MotorCoach\MotorCoachEvent;
use MlankaTech\AppBundle\Event\MotorCoach\MotorCoachEvents;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Monolog\Logger;

/**
 * TrainManager
 *
 * @DI\Service("train.manager")
 * @author  Mfana Ronald Conco <ronald.conco@mlankatech.co.za>
 * @package MlankaTechAppBundle
 * @subpackage Services
 * @version 0.0.1
 *
 */
class TrainManager
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
     * @var Event Dispatcher
     */
    private $eventDispatcher;

    /**
     *
     * Class construct
     *
     * @param EntityManager            $em
     * @param Logger                   $logger
     * @param StatusManager            $sm
     * @param ConditionManager         $conditionManager
     * @param EventDispatcherInterface $eventDispatcher
     * @DI\InjectParams({
     *     "em"                  = @DI\Inject("doctrine.orm.entity_manager"),
     *     "logger"              = @DI\Inject("logger"),
     *     "sm"                  = @DI\Inject("status.manager"),
     *     "conditionManager"    = @DI\Inject("condition.manager"),
     *     "eventDispatcher"     = @DI\Inject("event_dispatcher"),
     * })
     */
    public function __construct(
        EntityManager $em,
        Logger $logger,
        StatusManager $sm,
        ConditionManager $conditionManager,
        EventDispatcherInterface $eventDispatcher
    )
    {
        $this->em = $em;
        $this->logger = $logger;
        $this->sm = $sm;
        $this->conditionManager = $conditionManager;
        $this->eventDispatcher = $eventDispatcher;
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
     * Get train by id
     *
     * @param integer $id
     * @return MlankaTechAppBundle:Train
     */
    public function getById($id)
    {
        $this->logger->info("Service TrainManager getById()");
        return $this->em->getRepository('MlankaTechAppBundle:Train')
            ->find($id);
    }

    /**
     * Get train by slug
     * @param $slug
     * @return bool
     */
    public function getBySlug($slug)
    {
        $this->logger->info("Service TrainManager getBySlug()");
        $results = $this->em->getRepository('MlankaTechAppBundle:Train')
            ->findBySlug($slug);
        if(is_array($results)){
            return $results[0];
        }
        return false;
    }

    /**
     * Get query list of all trains
     *
     * @param array $options
     * @return Query
     */
    public function getListAll($options = array())
    {
        $this->logger->info("Service TrainManager getListAll()");

        return $this->em->getRepository('MlankaTechAppBundle:Train')
            ->getAllQueryList($options);

    }

    /**
     * Create train
     *
     * @param \MlankaTech\AppBundle\Entity\Train $train
     * @return \MlankaTech\AppBundle\Entity\Train
     */
    public function create(\MlankaTech\AppBundle\Entity\Train $train)
    {
        $this->logger->info("Service TrainManager create()");

        $train->setStatus($this->sm->active());
        $train->setCondition($this->conditionManager->unknown());

        if($this->getCurrentUser()){
            $train->setCreatedBy($this->getCurrentUser());
        }else{
            $train->setCreatedBy(NULL);
        }


        $this->em->persist($train);
        $this->em->flush();

        /**
         * Mark motor coach as assigned
         */
        $motorCoaches = $train->getMotorcoaches();

        if(!$motorCoaches->isEmpty()){
            foreach($motorCoaches as $coach){
                $coach->setTrain($train);
                $coach->setAssigned(true);
                $coach->setStatus($this->sm->offline());
                $this->eventDispatcher->dispatch(
                    MotorCoachEvents::ASSIGNED_TO_TRAIN,
                    new MotorCoachEvent($coach)
                );
            }
        }
        return $train;
    }

    /**
     * Update train
     *
     * @param \MlankaTech\AppBundle\Entity\Train $train
     * @return \MlankaTech\AppBundle\Entity\Train
     */
    public function update(\MlankaTech\AppBundle\Entity\Train $train)
    {
        $this->logger->info("Service TrainManager update()");

        $this->em->persist($train);
        $this->em->flush();
        return $train;
    }

}
