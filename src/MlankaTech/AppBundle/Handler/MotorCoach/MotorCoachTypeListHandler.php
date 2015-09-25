<?php

namespace MlankaTech\AppBundle\Handler\MotorCoach;

use Symfony\Component\HttpFoundation\Request;
use MlankaTech\AppBundle\Services\Core\MotorCoachTypeManager;
use MlankaTech\AppBundle\Services\Core\FlashMessageManager;
use JMS\DiExtraBundle\Annotation as DI;
use Monolog\Logger;

/**
 * MlankaTech\AppBundle\Handler\MotorCoach\MotorCoachTypeListHandler.
 *
 * @DI\Service("mlanka_tech_app.motor_coach_type_list_handler")
 *
 * @author Mfana Ronald Conco <ronald.conco@mlankatech.co.za>
 * @package MlankaTechAppBundle
 * @subpackage Handler\MotorCoach
 * @version 0.0.1
 */
class MotorCoachTypeListHandler
{
    /**
     * Monolog logger.
     *
     * @var object
     */
    protected $logger;

    /**
     * MotorCoachTypeManager.
     *
     * @var object
     */
    protected $motorCoachTypeManager;

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
     * @param MotorCoachTypeManager    $motorCoachTypeManager
     * @param FlashMessageManager      $flashManager
     * @param Logger                   $logger
     * @param Paginator                $paginator
     *
     * @DI\InjectParams({
     *     "motorCoachTypeManager"    = @DI\Inject("motor.coach.type.manager"),
     *     "flashManager"             = @DI\Inject("flash.message.manager"),
     *     "logger"                   = @DI\Inject("logger"),
     *     "paginator"                = @DI\Inject("knp_paginator"),
     * })
     */
    public function __construct(
        MotorCoachTypeManager $motorCoachTypeManager,
        FlashMessageManager $flashManager,
        Logger $logger,
        $paginator
    ) {
        $this->motorCoachTypeManager = $motorCoachTypeManager;
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
        $this->logger->info('MotorCoachTypeListHandler handle()');

        $search = $request->query->get('search');
        $sort = $request->query->get('sort', 'm.id');
        $direction = $request->query->get('direction', 'asc');
        $show = $request->query->get('show', '10');

        $options = array(
            'search' => $search,
            'sort' => $sort,
            'direction' => $direction,
            'show' => $show,
        );

        $pagination = $this->paginator->paginate(
            $this->motorCoachTypeManager->getListAll($options),
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
