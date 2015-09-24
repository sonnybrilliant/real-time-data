<?php

namespace MlankaTech\AppBundle\Handler\Security;

use JMS\DiExtraBundle\Annotation as DI;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Request;
use MlankaTech\AppBundle\Services\User\UserManager;
use MlankaTech\AppBundle\Services\Core\FlashMessageManager;
use Monolog\Logger;

/**
 * Class UserForgotPasswordHandler.
 *
 * @DI\Service("forgot_password.form_handler")
 *
 * @author Mfana Ronald Conco <ronald.conco@mlankatech.co.za>
 * @subpackage Handler\Security
 * @version 0.0.1
 */
class ForgotPasswordFormHandler
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
            return false;
        }

        $data = $form->getData();
        $this->logger->info('Email address is : '.$data['email']);
        $user = $this->userManager->getByEmail($data['email']);
        if (!is_object($user)) {
            $this->flashManager->getErrorMessage('Account not found in our records.');
            $this->logger->warn('ForgotPasswordFormHandler handle() Account '.$data['email'].' not found in our records.');

            return false;
        }

        $this->userManager->forgotPassword($user);
        $this->flashManager->getSuccessMessage('Your password reset link has been emailed to '.$data['email']);

        return true;
    }
}
