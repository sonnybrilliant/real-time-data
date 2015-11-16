<?php

namespace MlankaTech\AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class DashboardController extends Controller
{
    public function dashboardActivityAction(Request $request)
    {
        $client = $this->get('elephantio_client.your_key');
        $client->send('broadcast', ['username'=>'api','foo' => 'test']);

        return $this->render('MlankaTechAppBundle:Dashboard:dashboard.activity.html.twig',array(
            'action' => 'dashboard_activity',
            'page_header' => 'Activity',
            'breadcrumb' => 'Map activity'
        ));
    }
}