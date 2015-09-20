<?php

namespace MlankaTech\AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DashboardController extends Controller
{
    public function dashboardAction()
    {
        return $this->render('MlankaTechAppBundle:Dashboard:dashboard.html.twig',array(
            'action' => 'dashboard'
        ));
    }
}