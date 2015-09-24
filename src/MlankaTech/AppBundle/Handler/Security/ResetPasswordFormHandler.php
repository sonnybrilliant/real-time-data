<?php

/**
 * Created by PhpStorm.
 * User: tk-mac
 * Date: 15/05/28
 * Time: 7:53 PM.
 */
namespace MlankaTech\AppBundle\Handler\Security;

use JMS\DiExtraBundle\Annotation as DI;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Request;
use MlankaTech\AppBundle\Services\User\UserManager;
use MlankaTech\AppBundle\Services\Core\FlashMessageManager;
use Monolog\Logger;

/**
 * Class ResetPasswordFormHandler.
 *
 * @DI\Service("reset_password.form_handler")
 *
 * @author Mfana Ronald Conco <ronald.conco@mlankatech.co.za>
 * @subpackage Handler\Security
 * @version 0.0.1
 */
class ResetPasswordFormHandler
{
    /**
     * Monolog logger.
     *
     * @var object
     */
    protected $logger;

    /**
     * UserManager.
     *
     * @var \MlankaTech\AppBundle\Services\User\UserManager
     */
    protected $userManager;

    /**
     * flash manager.
     *
     * @var \MlankaTech\AppBundle\Services\Core\FlashMessageManager
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
     * @param Request       $request
     * @param FormInterface $form
     *
     * @return bool
     */
    public function handle(Request $request, FormInterface $form)
    {
        $this->logger->info('ForgotPasswordFormHandler handle()');

        if (!$request->isMethod('POST')) {
            return false;
        }

        $form->handleRequest($request);
        if (!$form->isValid()) {
            $this->flashManager->getErrorMessage();

            return false;
        }

        $user = $form->getData();

        $this->userManager->resetPassword($user);
        $this->flashManager->getSuccessMessage('Your password was changed successfully!');

        return true;
    }
}
