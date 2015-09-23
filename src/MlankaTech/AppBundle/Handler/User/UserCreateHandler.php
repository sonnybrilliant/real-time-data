<?php

namespace MlankaTech\AppBundle\Handler\User;

use MlankaTech\AppBundle\Services\User\UserManager;
use JMS\DiExtraBundle\Annotation as DI;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\FormInterface;
use MlankaTech\AppBundle\Services\Core\FlashMessageManager;
use Monolog\Logger;

/**
 * MlankaTech\AppBundle\Handler\User\UserCreateHandler.
 *
 * @DI\Service("mlanka_tech_app.user_create_handler")
 *
 * @author Tiko Banyini <admin@tkbean.co.za>
 *
 * @version 0.0.1
 */
class UserCreateHandler
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
     * @param FormInterface $form
     * @param Request       $request
     *
     * @return bool
     */
    public function handle(FormInterface $form, Request $request)
    {
        $this->logger->info('UserCreateHandler handle()');

        if (!$request->isMethod('POST')) {
            return false;
        }

        $form->bind($request);

        if (!$form->isValid()) {
            $this->flashManager->getErrorMessage();
            return false;
        }

        $validUser = $form->getData();

        $this->userManager->createUser($validUser);
        $this->flashManager->getSuccessMessage('User was added successfully!');

        return true;
    }
}
