<?php

namespace MlankaTech\AppBundle\Handler\User;

use Symfony\Component\HttpFoundation\Request;
use MlankaTech\AppBundle\Services\User\UserManager;
use MlankaTech\AppBundle\Services\Core\FlashMessageManager;
use JMS\DiExtraBundle\Annotation as DI;
use Symfony\Component\Form\FormInterface;
use Monolog\Logger;

/**
 * MlankaTech\AppBundle\Handler\User\Form\UserEditHandler.
 *
 * @DI\Service("mlanka_tech_app.user_edit_handler")
 *
 * @author Mfana Ronald Conco <ronald.conco@mlankatech.co.za>
 *
 * @version 0.0.1
 */
class UserEditHandler
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
    protected $userManager;

    /**
     * Flash manager.
     *
     * @var Service
     */
    protected $flashManager;

    /**
     * Class construct.
     *
     * @param UserManager         $userManager
     * @param FlashMessageManager $flashManager
     * @param Logger              $logger
     *
     * @DI\InjectParams({
     *     "userManager"         = @DI\Inject("user.manager"),
     *     "flashManager"        = @DI\Inject("flash.message.manager"),
     *     "logger"              = @DI\Inject("logger"),
     * })
     */
    public function __construct(
        UserManager $userManager,
        FlashMessageManager $flashManager,
        Logger $logger

    ) {
        $this->userManager = $userManager;
        $this->logger = $logger;
        $this->flashManager = $flashManager;
    }

    /**
     * Handle form request.
     *
     * @param \Symfony\Component\Form\FormInterface     $form
     * @param \Symfony\Component\HttpFoundation\Request $request
     *
     * @return bool
     */
    public function handle(FormInterface $form, Request $request)
    {
        $this->logger->info('UserEditFormHandler handle()');
        if (!$request->isMethod('POST')) {
            return false;
        }

        $form->bind($request);
        if (!$form->isValid()) {
            $this->flashManager->getErrorMessage();
            return false;
        }

        $this->userManager->update($form->getData());
        $this->flashManager->getSuccessMessage('update successfully!');
        return true;
    }
}
