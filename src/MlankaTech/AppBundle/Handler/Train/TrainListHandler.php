<?php

namespace MlankaTech\AppBundle\Handler\Train;

use Symfony\Component\HttpFoundation\Request;
use MlankaTech\AppBundle\Services\Train\TrainManager;
use MlankaTech\AppBundle\Services\Core\FlashMessageManager;
use JMS\DiExtraBundle\Annotation as DI;
use Monolog\Logger;

/**
 * MlankaTech\AppBundle\Handler\Train\TrainListHandler.
 *
 * @DI\Service("mlanka_tech_app.train_list_handler")
 *
 * @author Mfana Ronald Conco <ronald.conco@mlankatech.co.za>
 * @package MlankaTechAppBundle
 * @subpackage Handler\Train
 * @version 0.0.1
 */
class TrainListHandler
{
    /**
     * Monolog logger.
     *
     * @var object
     */
    protected $logger;

    /**
     * Train Manager.
     *
     * @var object
     */
    protected $trainManager;

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
     * @param TrainManager             $trainMananger
     * @param FlashMessageManager      $flashManager
     * @param Logger                   $logger
     * @param Paginator                $paginator
     *
     * @DI\InjectParams({
     *     "trainManager"             = @DI\Inject("train.manager"),
     *     "flashManager"             = @DI\Inject("flash.message.manager"),
     *     "logger"                   = @DI\Inject("logger"),
     *     "paginator"                = @DI\Inject("knp_paginator"),
     * })
     */
    public function __construct(
        TrainManager $trainManager,
        FlashMessageManager $flashManager,
        Logger $logger,
        $paginator
    ) {
        $this->trainManager = $trainManager;
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
        $this->logger->info('TrainListHandler handle()');

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
            $this->trainManager->getListAll($options),
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
