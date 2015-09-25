<?php

namespace MlankaTech\AppBundle\Handler\Train;

use Symfony\Component\HttpFoundation\Request;
use MlankaTech\AppBundle\Services\Core\TrainTypeManager;
use MlankaTech\AppBundle\Services\Core\FlashMessageManager;
use JMS\DiExtraBundle\Annotation as DI;
use Monolog\Logger;

/**
 * MlankaTech\AppBundle\Handler\Train\TrainTypeListHandler.
 *
 * @DI\Service("mlanka_tech_app.train_type_list_handler")
 *
 * @author Mfana Ronald Conco <ronald.conco@mlankatech.co.za>
 * @package MlankaTechAppBundle
 * @subpackage Handler\Train
 * @version 0.0.1
 */
class TrainTypeListHandler
{
    /**
     * Monolog logger.
     *
     * @var object
     */
    protected $logger;

    /**
     * TrainTypeManager.
     *
     * @var object
     */
    protected $trainTypeManager;

    /**
     * Session.
     *
     * @var object
     */
    protected $session;

    /**
     * Paginator.
     *
     * @var object
     */
    protected $paginator;

    /**
     * flash manager.
     *
     * @var \MlankaTech\AppBundle\Services\Core\FlashMessageManager
     */
    protected $flashManager;

    /**
     * Class construct.
     *
     * @param TrainTypeManager    $trainTypeManager
     * @param FlashMessageManager $flashManager
     * @param Logger              $logger
     * @param Paginator           $paginator
     *
     * @DI\InjectParams({
     *     "trainTypeManager"    = @DI\Inject("train.type.manager"),
     *     "flashManager"        = @DI\Inject("flash.message.manager"),
     *     "logger"              = @DI\Inject("logger"),
     *     "paginator"           = @DI\Inject("knp_paginator"),
     * })
     */
    public function __construct(
        TrainTypeManager $trainTypeManager,
        FlashMessageManager $flashManager,
        Logger $logger,
        $paginator
    ) {
        $this->trainTypeManager = $trainTypeManager;
        $this->logger = $logger;
        $this->paginator = $paginator;
        $this->flashManager = $flashManager;
    }

    /**
     * Handle list request.
     *
     * @param Request $request
     * @param $page
     *
     * @return array
     */
    public function handle(Request $request, $page)
    {
        $this->logger->info('TrainTypeListHandler handle()');

        $search = $request->query->get('search');
        $sort = $request->query->get('sort', 't.id');
        $direction = $request->query->get('direction', 'asc');
        $show = $request->query->get('show', '10');

        $options = array(
            'search' => $search,
            'sort' => $sort,
            'direction' => $direction,
            'show' => $show,
        );

        $pagination = $this->paginator->paginate(
            $this->trainTypeManager->getListAll($options),
            $request->query->get('page', $page), $show);

        if ($pagination->getTotalItemCount() == 0) {
            $this->flashManager->getWarningMessage('No results found.');
        }

        return array(
            'pagination' => $pagination,
            'direction' => $direction,
            'show' => $show
        );
    }
}
