<?php

namespace MlankaTech\AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use JMS\SecurityExtraBundle\Annotation\Secure;

class MotorCoachTypeController extends Controller
{

    /**
     * List motor coach types
     * @param Request $request
     * @param int $page
     * @Secure(roles="ROLE_ADMIN")
     * @return array
     */
    public function listAction(Request $request, $page = 1)
    {
        $this->get('logger')->info('MotorCoachTypeController listAction()');
        $handler = $this->get('mlanka_tech_app.motor_coach_type_list_handler');
        $pagination = $handler->handle($request,$page);
        $showOptions = array(10, 20, 30, 40, 50);

        return $this->render('MlankaTechAppBundle:MotorCoachTypes:list.html.twig',array(
            'action' => 'settings_motor_coach_type_list',
            'pagination' => $pagination['pagination'],
            'direction' => $pagination['direction'],
            'page_header' => 'List motor coach types',
            'breadcrumb' => 'List',
            'showOptions' => $showOptions,
            'showSelected' => $pagination['show'],
        ));
    }

}