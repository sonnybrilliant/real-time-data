<?php

namespace MlankaTech\AppBundle\Handler\User;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;
use MlankaTech\AppBundle\Services\User\UserManager;
use MlankaTech\AppBundle\Services\Core\FlashMessageManager;
use JMS\DiExtraBundle\Annotation as DI;
use Monolog\Logger;

/**
 * MlankaTech\AppBundle\Handler\User\UserListHandler.
 *
 * @DI\Service("mlanka_tech_app.user_list_handler")
 *
 * @author Mfana Ronald Conco <ronald.conco@mlankatech.co.za>
 *
 * @version 0.0.1
 */
class UserListHandler
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
     * @var object
     */
    protected $userManager;

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
     * @param UserManager         $userManager
     * @param FlashMessageManager $flashManager
     * @param Logger              $logger
     * @param Session             $session
     * @param Paginator           $paginator
     *
     * @DI\InjectParams({
     *     "userManager"         = @DI\Inject("user.manager"),
     *     "flashManager"        = @DI\Inject("flash.message.manager"),
     *     "logger"              = @DI\Inject("logger"),
     *     "session"             = @DI\Inject("session"),
     *     "paginator"           = @DI\Inject("knp_paginator"),
     * })
     */
    public function __construct(
        UserManager $userManager,
        FlashMessageManager $flashManager,
        Logger $logger,
        Session $session,
        $paginator
    ) {
        $this->userManager = $userManager;
        $this->logger = $logger;
        $this->session = $session;
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
        $this->logger->info('UserListHandler handle()');

        $search = $request->query->get('search');
        $sort = $request->query->get('sort', 'u.id');
        $direction = $request->query->get('direction', 'asc');
        $filterBy = $request->query->get('filterBy', 0);

        $options = array(
            'search' => $search,
            'sort' => $sort,
            'direction' => $direction,
            'filterBy' => $filterBy,
        );

        $pagination = $this->paginator->paginate(
            $this->userManager->getListAll($options),
            $request->query->get('page', $page), 10);

        if ($pagination->getTotalItemCount() == 0) {
            $this->flashManager->getWarningMessage('No results found.');
        }

        return array(
            'pagination' => $pagination,
            'direction' => $direction,
        );
    }
}
