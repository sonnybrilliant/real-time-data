<?php

namespace MlankaTech\AppBundle\Handler\Train;

use MlankaTech\AppBundle\Services\Train\TrainManager;
use JMS\DiExtraBundle\Annotation as DI;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\FormInterface;
use MlankaTech\AppBundle\Services\Core\FlashMessageManager;
use Monolog\Logger;

/**
 * MlankaTech\AppBundle\Handler\Train\TrainCreateHandler.
 *
 * @DI\Service("mlanka_tech_app.train_create_handler")
 * @author Mfana Ronald Conco <ronald.conco@mlankatech.co.za>
 * @subpackage Handler\User
 * @version 0.0.1
 */
class TrainCreateHandler
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
    protected $trainManager;

    /**
     * Flash manager.
     *
     * @var Service
     */
    protected $flashManager;

    /**
     * Class construct.
     *
     * @param TrainManager        $trainManager
     * @param FlashMessageManager $flashManager
     * @param Logger              $logger
     *
     * @DI\InjectParams({
     *     "trainManager"        = @DI\Inject("train.manager"),
     *     "flashManager"        = @DI\Inject("flash.message.manager"),
     *     "logger"              = @DI\Inject("logger"),
     * })
     */
    public function __construct(
        TrainManager $trainManager,
        FlashMessageManager $flashManager,
        Logger $logger

    ) {
        $this->trainManager = $trainManager;
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
        $this->logger->info('TrainCreateHandler handle()');

        if (!$request->isMethod('POST')) {
            return false;
        }

        $form->handleRequest($request);

        if (!$form->isValid()) {
            $this->flashManager->getErrorMessage();
            return false;
        }

        $validTrain = $form->getData();

        $this->trainManager->create($validTrain);
        $this->flashManager->getSuccessMessage('Train was added successfully!');
        return true;
    }
}
