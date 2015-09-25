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



}