<?php

namespace MlankaTech\AppBundle\Event\MotorCoach;

use Symfony\Component\EventDispatcher\Event;
use MlankaTech\AppBundle\Entity\MotorCoach;

/**
 * MlankaTech\AppBundle\Event\MotorCoach\MotorCoachEvent.
 *
 * @author Mfana Ronald Conco <ronald.conco@mlankatech.co.za>
 * @package MlankaTechAppBundle
 * @subpackage Events\MotorCoach
 * @version 0.0.1
 */
class MotorCoachEvent extends Event
{
    /**
     * MlankaTechAppBundle:MotorCoach.
     *
     * @var
     */
    private $motorCoach;

    /**
     * Class construct.
     *
     * @param MotorCoach $motorCoach
     */
    public function __construct(MotorCoach $motorCoach)
    {
        $this->motorCoach = $motorCoach;
    }

    /**
     * Get motor coach.
     *
     * @return MlankaTechAppBundle:MotorCoach
     */
    public function getMotorCoach()
    {
        return $this->motorCoach;
    }
}
