<?php

namespace MlankaTech\AppBundle\EventListener\MotorCoach;

use Symfony\Component\Config\Definition\Exception\Exception;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use JMS\DiExtraBundle\Annotation as DI;
use JMS\DiExtraBundle\Annotation\Tag;
use MlankaTech\AppBundle\Event\MotorCoach\MotorCoachEvent;
use MlankaTech\AppBundle\Event\MotorCoach\MotorCoachEvents;
use MlankaTech\AppBundle\Services\MotorCoach\MotorCoachManager;
use Monolog\Logger;

/**
 * Class OnMotorCoachAssignListener.
 *
 * Triggered when a train is assigned a motor coach
 *
 * @DI\Service("listener.on_motor_coach_assign")
 * @Tag("kernel.event_subscriber")
 *
 * @author  Mfana Ronald Conco <ronald.conco@mlankatech.co.za>
 * @package MlankaTechAppBundle
 * @subpackage EventHandler\MotorCoach
 * @version 0.0.1
 */
class OnMotorCoachAssignListener implements EventSubscriberInterface
{
    /**
     * Monolog logger.
     *
     * @var Service
     */
    private $logger;

    /**
     * MotorCoachManager.
     *
     * @var object
     */
    protected $motorCoachManager;

    /**
     * Get Subscription Events.
     *
     * @return Array
     */
    public static function getSubscribedEvents()
    {
        return array(
            MotorCoachEvents::ASSIGNED_TO_TRAIN => 'onTrainAssign',
        );
    }

    /**
     * Class construct.
     *
     * @param Logger              $logger
     * @param MotorCoachManager   $motorCoachManager
     *
     * @DI\InjectParams({
     *     "logger"              = @DI\Inject("logger"),
     *     "motorCoachManager"   = @DI\Inject("motor.coach.manager")
     * })
     */
    public function __construct(
        Logger $logger,
        MotorCoachManager $motorCoachManager
    ) {
        $this->logger = $logger;
        $this->motorCoachManager = $motorCoachManager;
    }

    /**
     * On train assign event, update motor coach
     *
     * @param MotorCoachEvent $motorCoach
     */
    public function onTrainAssign(MotorCoachEvent $motorCoach)
    {
        $this->logger->info('Event listener OnMotorCoachAssignListener onTrainAssign()');
        $this->motorCoachManager->update($motorCoach->getMotorCoach());

    }
}
