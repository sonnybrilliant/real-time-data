<?php

namespace MlankaTech\AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use JMS\SecurityExtraBundle\Annotation\Secure;
use MlankaTech\AppBundle\Entity\Train;

/**
 * MlankaTech\AppBundle\Controller\TrainController.
 *
 * @author Mfana Ronald Conco <ronald.conco@mlankatech.co.za>
 * @package MlankaTechAppBundle
 * @subpackage Controller
 * @version 0.0.1
 */
class TrainController extends Controller
{
    /**
     * List all trains
     *
     * @author Mfana Ronald Conco <ronald.conco@mlankatech.co.za>
     * @param Request $request
     * @param int $page
     * @Secure(roles="ROLE_TRAIN_LIST")
     * @return array
     */
    public function listAction(Request $request, $page = 1)
    {
        $this->get('logger')->info('TrainController  listAction()');
        $handler = $this->get('mlanka_tech_app.train_list_handler');
        $pagination = $handler->handle($request,$page);
        $showOptions = array(10, 20, 30, 40, 50);

        return $this->render('MlankaTechAppBundle:Train:list.html.twig',array(
            'action' => 'train_list',
            'pagination' => $pagination['pagination'],
            'direction' => $pagination['direction'],
            'page_header' => 'List trains',
            'breadcrumb' => 'List',
            'showOptions' => $showOptions,
            'showSelected' => $pagination['show'],
        ));
    }

    /**
     * Create train
     *
     * @author Mfana Ronald Conco <ronald.conco@mlankatech.co.za>
     * @param Request $request
     * @Secure(roles="ROLE_TRAIN_CREATE")
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function createAction(Request $request)
    {
        $this->get('logger')->info('TrainController createAction()');

        $train = new Train();
        $form = $this->createForm("TrainCreateType",$train);
        $formHandler = $this->get('mlanka_tech_app.train_create_handler');
        if($formHandler->handle($form,$request)){
            return $this->redirect($this->generateUrl('mlanka_tech_app.train_list') . '.html');
        }

        return $this->render('MlankaTechAppBundle:Train:create.html.twig',array(
            'action' => 'train_create',
            'train'=> $train,
            'form' => $form->createView(),
            'page_header' => 'Add new train',
            'breadcrumb' => 'Add'
        ));
    }


    /**
     * Edit train
     *
     * @author Mfana Ronald Conco <ronald.conco@mlankatech.co.za>
     * @param Request $request
     * @Secure(roles="ROLE_TRAIN_CREATE")
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function editAction(Request $request, Train $train)
    {
        $this->get('logger')->info('TrainController editAction()');

        $form = $this->createForm("TrainEditType",$train);
        $formHandler = $this->get('mlanka_tech_app.train_edit_handler');
        if($formHandler->handle($form,$request)){
            return $this->redirect($this->generateUrl('mlanka_tech_app.train_list') . '.html');
        }

        return $this->render('MlankaTechAppBundle:Train:edit.html.twig',array(
            'action' => 'train_edit',
            'train'=> $train,
            'form' => $form->createView(),
            'page_header' => 'Edit train',
            'breadcrumb' => 'Edit'
        ));
    }

    /**
     * Train profile
     *
     * @author Mfana Ronald Conco <ronald.conco@mlankatech.co.za>
     * @param Request $request
     * @param Train $train
     * @ParamConverter("train", class="MlankaTechAppBundle:Train", options={"slug" = "slug"})
     * @Secure(roles="ROLE_TRAIN_PROFILE")
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function profileAction(Request $request, Train $train)
    {
        $this->get('logger')->info('TrainController  profileAction()');

        return $this->render('MlankaTechAppBundle:Train:profile.html.twig',array(
            'action' => 'train_profile',
            'train'=> $train,
            'page_header' => 'Train profile',
            'breadcrumb' => 'Profile'
        ));
    }


    /**
     * Train monitor
     *
     * @author Mfana Ronald Conco <ronald.conco@mlankatech.co.za>
     * @param Request $request
     * @param Train $train
     * @ParamConverter("train", class="MlankaTechAppBundle:Train", options={"slug" = "slug"})
     * @Secure(roles="ROLE_TRAIN_MONITOR")
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function monitorAction(Request $request, Train $train)
    {
        $this->get('logger')->info('TrainController  profileAction()');

        $motorCoaches = array();
        foreach($train->getMotorcoaches() as $motorCoach){
            $motorCoaches[] = $motorCoach->getUnit();
        ;}

        shuffle($motorCoaches);
        return $this->render('MlankaTechAppBundle:Train:monitor.html.twig',array(
            'action' => 'train_monitor',
            'train'=> $train,
            'page_header' => 'Train monitor',
            'breadcrumb' => 'Monitor',
            'motorCoaches' => $motorCoaches
        ));
    }


}