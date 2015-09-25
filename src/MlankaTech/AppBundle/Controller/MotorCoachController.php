<?php

namespace MlankaTech\AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use JMS\SecurityExtraBundle\Annotation\Secure;
use MlankaTech\AppBundle\Entity\MotorCoach;

/**
 * MlankaTech\AppBundle\Controller\MotorCoachController.
 *
 * @author Mfana Ronald Conco <ronald.conco@mlankatech.co.za>
 * @package MlankaTechAppBundle
 * @subpackage Controller
 * @version 0.0.1
 */
class MotorCoachController extends Controller
{

    /**
     * List all motor coaches
     *
     * @author Mfana Ronald Conco <ronald.conco@mlankatech.co.za>
     * @param Request $request
     * @param int $page
     * @Secure(roles="ROLE_MOTOR_COACH_LIST")
     * @return array
     */
    public function listAction(Request $request, $page = 1)
    {
        $this->get('logger')->info('MotorCoachController listAction()');
        $handler = $this->get('mlanka_tech_app.motor_coach_list_handler');
        $pagination = $handler->handle($request,$page);
        $showOptions = array(10, 20, 30, 40, 50);

        return $this->render('MlankaTechAppBundle:MotorCoach:list.html.twig',array(
            'action' => 'motor_coach_list',
            'pagination' => $pagination['pagination'],
            'direction' => $pagination['direction'],
            'page_header' => 'List motor coaches',
            'breadcrumb' => 'List',
            'showOptions' => $showOptions,
            'showSelected' => $pagination['show'],
        ));
    }

    /**
     * Create motor coach
     *
     * @author Mfana Ronald Conco <ronald.conco@mlankatech.co.za>
     * @param Request $request
     * @Secure(roles="ROLE_MOTOR_COACH_CREATE")
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function createAction(Request $request)
    {
        $this->get('logger')->info('MotorCoachController createAction()');

        $motorCoach = new MotorCoach();
        $form = $this->createForm("MotorCoachCreateType",$motorCoach);
        $formHandler = $this->get('mlanka_tech_app.motor_coach_create_handler');
        if($formHandler->handle($form,$request)){
            return $this->redirect($this->generateUrl('mlanka_tech_app.motor_coach_list') . '.html');
        }

        return $this->render('MlankaTechAppBundle:MotorCoach:create.html.twig',array(
            'action' => 'motor_coach_create',
            'motor_coach'=> $motorCoach,
            'form' => $form->createView(),
            'page_header' => 'Add new motor coach',
            'breadcrumb' => 'Add'
        ));
    }

    /**
     * Edit motor coach
     *
     * @author Mfana Ronald Conco <ronald.conco@mlankatech.co.za>
     * @param Request $request
     * @Secure(roles="ROLE_MOTOR_COACH_EDIT")
     * @param MotorCoach $motorCoach
     * @ParamConverter("motorCoach", class="MlankaTechAppBundle:MotorCoach", options={"slug" = "slug"})
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function editAction(Request $request, MotorCoach $motorCoach)
    {
        $this->get('logger')->info('MotorCoachController editAction()');

        $form = $this->createForm("MotorCoachEditType",$motorCoach);
        $formHandler = $this->get('mlanka_tech_app.motor_coach_edit_handler');
        if($formHandler->handle($form,$request)){
            return $this->redirect($this->generateUrl('mlanka_tech_app.motor_coach_list') . '.html');
        }

        return $this->render('MlankaTechAppBundle:MotorCoach:edit.html.twig',array(
            'action' => 'motor_coach_edit',
            'motorCoach'=> $motorCoach,
            'form' => $form->createView(),
            'page_header' => 'Edit motor coach',
            'breadcrumb' => 'Edit'
        ));
    }

    /**
     * Motor coach profile
     *
     * @author Mfana Ronald Conco <ronald.conco@mlankatech.co.za>
     * @param Request $request
     * @param MotorCoach $motorCoach
     * @ParamConverter("motorCoach", class="MlankaTechAppBundle:MotorCoach", options={"slug" = "slug"})
     * @Secure(roles="ROLE_MOTOR_COACH_PROFILE")
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function profileAction(Request $request, MotorCoach $motorCoach)
    {
        $this->get('logger')->info('MotorCoachController  profileAction()');

        return $this->render('MlankaTechAppBundle:MotorCoach:profile.html.twig',array(
            'action' => 'motor_coach_profile',
            'motorCoach'=> $motorCoach,
            'page_header' => 'Motor coach profile',
            'breadcrumb' => 'Profile'
        ));
    }

}