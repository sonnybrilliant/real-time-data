<?php

namespace MlankaTech\AppBundle\Handler\MotorCoach;

use MlankaTech\AppBundle\Services\MotorCoach\MotorCoachManager;
use JMS\DiExtraBundle\Annotation as DI;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\FormInterface;
use MlankaTech\AppBundle\Services\Core\FlashMessageManager;
use Monolog\Logger;

/**
 * MlankaTech\AppBundle\Handler\MotorCoach\MotorCoachCreateHandler.
 *
 * @DI\Service("mlanka_tech_app.motor_coach_create_handler")
 * @author Mfana Ronald Conco <ronald.conco@mlankatech.co.za>
 * @subpackage Handler\User
 * @version 0.0.1
 */
class MotorCoachCreateHandler
{
    /**
     * Monolog logger.
     *
     * @var Service
     */
    protected $logger;

    /**
     * UserManager.
     *
     * @var Service
     */
    protected $motorCoachManager;

    /**
     * Flash manager.
     *
     * @var Service
     */
    protected $flashManager;

    /**
     * Class construct.
     *
     * @param MotorCoachManager   $motorCoachManager
     * @param FlashMessageManager $flashManager
     * @param Logger              $logger
     *
     * @DI\InjectParams({
     *     "motorCoachManager"   = @DI\Inject("motor.coach.manager"),
     *     "flashManager"        = @DI\Inject("flash.message.manager"),
     *     "logger"              = @DI\Inject("logger"),
     * })
     */
    public function __construct(
        MotorCoachManager $motorCoachManager,
        FlashMessageManager $flashManager,
        Logger $logger

    ) {
        $this->motorCoachManager = $motorCoachManager;
        $this->logger = $logger;
        $this->flashManager = $flashManager;
    }

    /**
     * @param FormInterface $form
     * @param Request       $request
     *
     * @return bool
     */
    public function handle(FormInterface $form, Request $request)
    {
        $this->logger->info('MotorCoachCreateHandler handle()');

        if (!$request->isMethod('POST')) {
            return false;
        }

        $form->handleRequest($request);

        if (!$form->isValid()) {
            $this->flashManager->getErrorMessage();
            return false;
        }

        $validMotorCoach = $form->getData();

        $this->motorCoachManager->create($validMotorCoach);
        $this->flashManager->getSuccessMessage('Motor coach was added successfully!');
        return true;
    }
}
