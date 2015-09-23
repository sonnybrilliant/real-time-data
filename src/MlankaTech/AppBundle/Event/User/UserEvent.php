<?php

namespace MlankaTech\AppBundle\Event\User;

use Symfony\Component\EventDispatcher\Event;
use MlankaTech\AppBundle\Entity\User;

/**
 * MlankaTech\AppBundle\Event\User\UserEvent.
 *
 * @author Mfana Ronald Conco <ronald.conco@mlankatech.co.za>
 *
 * @version 0.0.1
 */
class UserEvent extends Event
{
    /**
     * MlankaTechAppBundle:User.
     *
     * @var
     */
    private $user;

    /**
     * Class construct.
     *
     * @param \MlankaTech\AppBundle\Entity\User $user
     */
    public function __construct(\MlankaTech\AppBundle\Entity\User $user)
    {
        $this->user = $user;
    }

    /**
     * Get user.
     *
     * @return MlankaTechAppBundle:User
     */
    public function getUser()
    {
        return $this->user;
    }
}
