<?php

namespace MlankaTech\AppBundle\Handler\MotorCoach;

use Symfony\Component\HttpFoundation\Request;
use MlankaTech\AppBundle\Services\MotorCoach\MotorCoachManager;
use MlankaTech\AppBundle\Services\Core\FlashMessageManager;
use JMS\DiExtraBundle\Annotation as DI;
use Monolog\Logger;

/**
 * MlankaTech\AppBundle\Handler\MotorCoach\MotorCoachListHandler.
 *
 * @DI\Service("mlanka_tech_app.motor_coach_list_handler")
 *
 * @author Mfana Ronald Conco <ronald.conco@mlankatech.co.za>
 * @package MlankaTechAppBundle
 * @subpackage Handler\MotorCoach
 * @version 0.0.1
 */
class MotorCoachListHandler
{
    /**
     * Monolog logger.
     *
     * @var object
     */
    protected $logger;

    /**
     * MotorCoachManager.
     *
     * @var object
     */
    protected $motorCoachManager;

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
     * @param MotorCoachManager        $motorCoachManager
     * @param FlashMessageManager      $flashManager
     * @param Logger                   $logger
     * @param Paginator                $paginator
     *
     * @DI\InjectParams({
     *     "motorCoachManager"        = @DI\Inject("motor.coach.manager"),
     *     "flashManager"             = @DI\Inject("flash.message.manager"),
     *     "logger"                   = @DI\Inject("logger"),
     *     "paginator"                = @DI\Inject("knp_paginator"),
     * })
     */
    public function __construct(
        MotorCoachManager $motorCoachManager,
        FlashMessageManager $flashManager,
        Logger $logger,
        $paginator
    ) {
        $this->motorCoachManager = $motorCoachManager;
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
        $this->logger->info('MotorCoachListHandler handle()');

        $search = $request->query->get('search');
        $sort = $request->query->get('sort', 'm.updatedAt');
        $direction = $request->query->get('direction', 'DESC');
        $show = $request->query->get('show', '10');

        $options = array(
            'search' => $search,
            'sort' => $sort,
            'direction' => $direction,
            'show' => $show,
        );

        $pagination = $this->paginator->paginate(
            $this->motorCoachManager->getListAll($options),
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
