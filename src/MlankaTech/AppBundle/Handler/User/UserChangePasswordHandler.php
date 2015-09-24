<?php

namespace MlankaTech\AppBundle\Handler\User;

use MlankaTech\AppBundle\Entity\User;
use Symfony\Component\HttpFoundation\Request;
use MlankaTech\AppBundle\Services\User\UserManager;
use MlankaTech\AppBundle\Services\Core\FlashMessageManager;
use JMS\DiExtraBundle\Annotation as DI;
use Symfony\Component\Form\FormInterface;
use Monolog\Logger;

/**
 * MlankaTech\AppBundle\Handler\User\Form\UserChangePasswordHandler.
 *
 * @DI\Service("mlanka_tech_app.user_change_password_handler")
 * @author Mfana Ronald Conco <ronald.conco@mlankatech.co.za>
 * @subpackage Handler\User
 * @version 0.0.1
 */
class UserChangePasswordHandler
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
    public function handle(FormInterface $form, Request $request, User $user)
    {
        $this->logger->info('UserChangePasswordHandler= handle()');
        if (!$request->isMethod('POST')) {
            return false;
        }

        $form->handleRequest($request);
        if (!$form->isValid()) {
            $this->flashManager->getErrorMessage();

            return false;
        }

        $userChangePassword = $form->getData();
        $user->setPassword($userChangePassword->getNewPassword());
        $this->userManager->resetPassword($user);
        $this->flashManager->getSuccessMessage('Your password was changed successfully!');

        return true;
    }
}
