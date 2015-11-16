<?php

namespace MlankaTech\AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use ElephantIO\Exception\ServerConnectionFailureException;
use Nc\Bundle\ElephantIOBundle\Service\Client as ElephantClient;
use Symfony\Component\HttpFoundation\JsonResponse;

class ApiController extends Controller
{
    /**
     * Broadcast socket
     * @param Request $request
     * @return JsonResponse
     */
    public function broadcastAction(Request $request)
    {
        $this->get('logger')->info('ApiController  broadcastAction()');
        $feed = array(
            'trainId' => $request->get('trainId'),
            'trainName' => $request->get('trainName'),
            'coachId' => $request->get('trainId'),
            'coachName' => $request->get('coachName'),
            'gpsTime' => $request->get('gpsTime'),
            'gpsSpeed' => $request->get('gpsSpeed'),
            'lat' => $request->get('lat'),
            'long' => $request->get('long'),
            'lineVoltage' => $request->get('lineVoltage'),
            'maOutPutVoltage' => $request->get('maOutPutVoltage'),
            'speedo' => $request->get('speedo'),
            'brakeVacuum' => $request->get('brakeVacuum'),
            'boggie1Current' => $request->get('boggie1Current'),
            'boggie2Current' => $request->get('boggie2Current'),
            'shaftEncoder1' => $request->get('shaftEncoder1'),
            'shaftEncoder2' => $request->get('shaftEncoder2'),
            'shaftEncoder3' => $request->get('shaftEncoder3'),
            'shaftEncoder4' => $request->get('shaftEncoder4'),
            'condition' => $request->get('condition'),
            'badge' =>$request->get('badge'),
            'error' => $request->get('error'),
            'status' => $request->get('status')
        );

        try{
            if(!empty($feed)){
                $this->get('elephantio_client.your_key')->send('broadcast', $feed);
            }
        }catch(ServerConnectionFailureException $e){
            $this->get('logger')->error("Failed connecting to Socket server :". $e->getMessage());
        }
        $data = 'good';
        return New JsonResponse($data);
    }
}