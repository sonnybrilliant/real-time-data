<?php

namespace MlankaTech\AppBundle\Handler\MotorCoach;

use Doctrine\ORM\EntityManager;
use MlankaTech\AppBundle\Entity\MotorCoach;
use JMS\DiExtraBundle\Annotation as DI;
use JMS\DiExtraBundle\Annotation\Inject;
use MlankaTech\AppBundle\Services\Train\TrainManager;
use MlankaTech\AppBundle\Services\MotorCoach\MotorCoachManager;
use MlankaTech\AppBundle\Entity\MotorCoachTransaction;
use MlankaTech\AppBundle\Services\Core\StatusManager;
use MlankaTech\AppBundle\Services\Core\ConditionManager;
use Monolog\Logger;
use GuzzleHttp\Exception\ClientException;

/**
 * MotorCoachTransactionManager
 *
 * @DI\Service("motor.coach.transaction.handler")
 * @author  Mfana Ronald Conco <ronald.conco@mlankatech.co.za>
 * @package MlankaTechAppBundle
 * @subpackage Handler/MotorCoach
 * @version 0.0.1
 *
 */
class MotorCoachTransactionHandler
{
    /**
     * @var Monolog logger
     */
    protected $logger;

    /**
     * @var Entity manager
     */
    protected $em;

    /**
     * @var Status manager
     */
    protected $sm;

    /**
     * @var Condition manager
     */
    protected $conditionManager;

    /**
     * MotorCoachManager.
     *
     * @var object
     */
    protected $motorCoachManager;

    /**
     * Train Manager.
     *
     * @var object
     */
    protected $trainManager;

    /**
     * Security Storage Token
     * @var object
     * @Inject("security.token_storage", required = false)
     */
    public $securityTokenStorage;

    /**
     * Guzzle client
     * @var object
     * @Inject("guzzle.client.api_broadcast", required = false)
     */
    public $guzzle;

    /**
     * Keep track of errors
     * @var null
     */
    private $errorMessage = null;

    /**
     *
     * Class construct
     *
     * @param EntityManager     $em
     * @param Logger            $logger
     * @param StatusManager     $sm
     * @param ConditionManager  $conditionManager
     * @param MotorCoachManager $motorCoachManager
     * @param TrainManager      $trainMananger
     *
     * @DI\InjectParams({
     *     "em"                  = @DI\Inject("doctrine.orm.entity_manager"),
     *     "logger"              = @DI\Inject("logger"),
     *     "sm"                  = @DI\Inject("status.manager"),
     *     "conditionManager"    = @DI\Inject("condition.manager"),
     *     "motorCoachManager"   = @DI\Inject("motor.coach.manager"),
     *     "trainManager"        = @DI\Inject("train.manager")
     * })
     */
    public function __construct(
        EntityManager $em,
        Logger $logger,
        StatusManager $sm,
        ConditionManager $conditionManager,
        MotorCoachManager $motorCoachManager,
        TrainManager $trainManager

    )
    {
        $this->em = $em;
        $this->logger = $logger;
        $this->sm = $sm;
        $this->conditionManager = $conditionManager;
        $this->motorCoachManager = $motorCoachManager;
        $this->trainManager = $trainManager;
    }

    public function process($payload)
    {
        $this->logger->info('Service MotorCoachTransactionHandler process()');

        $latitude = preg_replace("/[^A-Za-z0-9\\/'.-]/", '-',$payload->lat);
        $latitude = str_replace('------','-',$latitude);
        $latitude = str_replace('--','-',$latitude);
        $latitude =  str_replace("-S",'"S',$latitude);

        if(!strpos($latitude,"S-")){
            $latitude =  str_replace("S",'S-',$latitude);
        }
        var_dump($latitude);
        $latitude =  $this->parse($latitude);

        $longitude = preg_replace("/[^A-Za-z0-9\\/'.-]/", '-',$payload->long);
        $longitude = str_replace('------','-',$longitude);
        $longitude = str_replace('--','-',$longitude);
        $longitude =  str_replace("-E",'"E',$longitude);
        if(!strpos($longitude,"E-")){
            $longitude=  str_replace("E",'E-',$longitude);
        }
        var_dump($longitude);
        $longitude =  $this->parse($longitude);

        $sanitizedData = array(
            'coachName' => $payload->coachName,
            'lineVoltage' => $payload->lineVoltage,
            'gpsTime' => $payload->gpsTime,
            'gpsSpeed' => $payload->gpsSpeed,
            'lat' => $latitude,
            'long' => $longitude,
            'boggieCurrent1' => $payload->boggieCurrent1,
            'boggieCurrent2' => $payload->boggieCurrent2,
            'breakValve' => $payload->breakValve,
            'Supply100' => $payload->Supply100,
            'speedo' => $payload->speedo,
            'shaftEncode1' => $payload->shaftEncode1,
            'shaftEncode2' => $payload->shaftEncode2,
            'shaftEncode3' => $payload->shaftEncode3,
            'shaftEncode4' => $payload->shaftEncode4,


        );

        $this->logMotorCoachTransaction($sanitizedData);

        //update train transaction

        //update train
    }

    public function logMotorCoachTransaction($data)
    {
        $this->logger->info('Service MotorCoachTransactionHandler logMotorCoachTransaction()');

        $motorCoaches = $this->motorCoachManager->getBySlug(strtolower($data['coachName']));
        if(sizeof($motorCoaches) > 0){
            $motorCoach = $motorCoaches[0];
            $trans = new MotorCoachTransaction();
            $trans->setMotorCoachName($data['coachName']);
            $trans->setMotorCoach($motorCoach);
            $trans->setMotorCoachType($motorCoach->getType());
            $trans->setGpsTime(new \DateTime($data['gpsTime'],new \DateTimeZone('Africa/Johannesburg')));
            $trans->setLatitude($data['lat']);
            $trans->setLongitude($data['long']);
            $trans->setGpsSpeed($data['gpsSpeed']);
            $trans->setLineVoltage($data['lineVoltage']);
            $trans->setMAOutputVoltage($data['Supply100']);
            $trans->setSpeedo($data['speedo']);
            $trans->setBrakeVacuum($data['breakValve']);
            $trans->setBoggie1Current($data['boggieCurrent1']);
            $trans->setBoggie2Current($data['boggieCurrent2']);
            $trans->setShaftEncoder1Speed($data['shaftEncode1']);
            $trans->setShaftEncoder2Speed($data['shaftEncode2']);
            $trans->setShaftEncoder3Speed($data['shaftEncode3']);
            $trans->setShaftEncoder4Speed($data['shaftEncode4']);
            $trans->setStatus($this->sm->online());
            $conditionalRules = $this->applyRules($data);
            $trans->setCondition($conditionalRules);
            $trans->setErrorMessage($this->errorMessage);

            $train = $motorCoach->getTrain();
            if($train){
                $trans->setTrainName($train->getUnit());
                $trans->setTrain($train);
                $trans->setTrainType($train->getType());

                $train->setStatus($this->sm->online());
                $train->setCondition($conditionalRules);
                $this->em->persist($train);
            }

            $motorCoach->setErrorData($this->errorMessage);
            $motorCoach->setCondition($conditionalRules);
            $motorCoach->setStatus($this->sm->online());



            $this->em->persist($trans);
            $this->em->persist($motorCoach);
            $this->em->flush();

            //Publish event to socket server
            $this->publishFeed($trans);
            return;
        }else{
            //create new motor coach
            $motorCoach = new MotorCoach();
            $motorCoach->setUnit($data['coachName']);
            $motorCoach->setStatus($this->sm->offline());
            $motorCoach->setCondition($this->conditionManager->unknown());

            $this->em->persist($motorCoach);
            $this->em->flush();
        }

    }

    /**
     * Apply Conditional rules
     *
     * @param $data
     * @return mixed
     */
    private function applyRules($data)
    {
        $this->logger->info("Service MotorCoachTransactionHandler applyRules()");

        $critical = $this->conditionManager->critical();
        $warning  = $this->conditionManager->warning();
        $good     = $this->conditionManager->good();

        $this->errorMessage = null;

        if($data['lat'] == '0' || $data['long'] == '0')
        {
            $this->errorMessage = "GPS not reading";
            return $warning;
        }

        if(($data['breakValve'] >= 0)  && ($data['breakValve'] < 59 ) && ($data['gpsSpeed'] > 1))
        {
            $this->errorMessage = "Brake pressure is low";
            return $critical;
        }elseif(($data['breakValve'] > 59)  && ($data['breakValve'] < 64 )){
            return $good;
        }

        if(($data['Supply100'] >= 0)  && ($data['Supply100'] < 90 ) && ($data['gpsSpeed'] > 1)){
            $this->errorMessage = "MA Voltage is low";
            return $critical;
        }elseif(($data['Supply100'] >= 91)  && ($data['Supply100'] < 114 )){
            return $good;
        }

        $tmpLineVoltage = $data['lineVoltage'];
        $strLineVoltage = substr($tmpLineVoltage,0,1);
        $strLineVoltage = $strLineVoltage.'.'.substr($tmpLineVoltage,1,strlen($tmpLineVoltage));



        if((floatval($strLineVoltage) > 2.8)  && (floatval($strLineVoltage) < 3.8 )){
            return $good;
        }else{
            if((floatval($strLineVoltage) > 2.8) && ($data['gpsSpeed'] > 1) ){
                $this->errorMessage = "line voltage is low";
            }elseif((floatval($strLineVoltage) < 3.8) && ($data['gpsSpeed'] > 1)){
                $this->errorMessage = "line voltage is high";
            }
            return $critical;
        }

        if(($data['gpsSpeed'] >= 0)  && ($data['gpsSpeed'] < 90 )){
            return $good;
        }elseif(($data['gpsSpeed'] >= 91)  && ($data['gpsSpeed'] < 95 )){
            $this->errorMessage = "Speed is high";
            return $warning;
        }elseif($data['gpsSpeed'] > 95){
            $this->errorMessage = "Speed is too high!!";
            return $critical;
        }

        return $good;
    }



    /**
     * Converting From DMS To Decimal
     *
     * @param int $degrees
     * @param int $minutes
     * @param int $seconds
     * @param string $direction
     * @return bool|int|string
     *
     * @link https://www.dougv.com/2012/03/converting-latitude-and-longitude-coordinates-between-decimal-and-degrees-minutes-seconds/
     */
    function DMS2Decimal($degrees = 0, $minutes = 0, $seconds = 0, $direction = 's') {
        //converts DMS coordinates to decimal
        //returns false on bad inputs, decimal on success

        //direction must be n, s, e or w, case-insensitive
        $d = strtolower($direction);
        $ok = array('n', 's', 'e', 'w');

        //degrees must be integer between 0 and 180
        if(!is_numeric($degrees) || $degrees < 0 || $degrees > 180) {
            $decimal = false;
        }
        //minutes must be integer or float between 0 and 59
        elseif(!is_numeric($minutes) || $minutes < 0 || $minutes > 59) {
            $decimal = false;
        }
        //seconds must be integer or float between 0 and 59
        elseif(!is_numeric($seconds) || $seconds < 0 || $seconds > 59) {
            $decimal = false;
        }
        elseif(!in_array($d, $ok)) {
            $decimal = false;
        }
        else {
            //inputs clean, calculate
            $decimal = $degrees + ($minutes / 60) + ($seconds / 3600);

            //reverse for south or west coordinates; north is assumed
            if($d == 's' || $d == 'w') {
                $decimal *= -1;
            }
        }
        return $decimal;
    }

    /**
     * Parse coordinates
     *
     * @param $degCoordinates
     * @return bool|int|string
     */
    private function parse($degCoordinates){
        $dpos=strpos($degCoordinates,'-');
        $mpos=strpos($degCoordinates,"'");
        $spos=strpos($degCoordinates,'"');
        $mlen=(($mpos-$dpos)-1);
        $slen=(($spos-$mpos)-1);
        $direction=substr(strrev($degCoordinates),1,1);
        $degrees=substr($degCoordinates,0,$dpos);
        $minutes=substr($degCoordinates,$dpos+1,$mlen);
        $seconds=substr($degCoordinates,$mpos+1,$slen);
        return $this->DMS2Decimal($degrees,$minutes,$seconds,$direction);
    }

    /**
     * Publish event to socket server
     *
     * @param MotorCoachTransaction $train
     */
    private function publishFeed(MotorCoachTransaction $train)
    {
        $this->logger->info('Service MotorCoachTransactionHandler publishFeed()');

        $feed = array(
            'trainId' => '',
            'trainName' => '',
            'coachId' => trim($train->getMotorCoach()->getId()),
            'coachName' => trim($train->getMotorCoachName()),
            'gpsTime' => trim($train->getGpsTime()->getTimestamp()),
            'gpsSpeed' => trim($train->getGpsSpeed()),
            'lat' => $train->getLatitude(),
            'long' => $train->getLongitude(),
            'lineVoltage' => trim($train->getLineVoltage()),
            'maOutPutVoltage' => trim($train->getMAOutputVoltage()),
            'speedo' => trim($train->getSpeedo()),
            'brakeVacuum' => trim($train->getBrakeVacuum()),
            'boggie1Current' => trim($train->getBoggie1Current()),
            'boggie2Current' => trim($train->getBoggie2Current()),
            'shaftEncoder1' => trim($train->getShaftEncoder1Speed()),
            'shaftEncoder2' => trim($train->getShaftEncoder2Speed()),
            'shaftEncoder3' => trim($train->getShaftEncoder3Speed()),
            'shaftEncoder4' => trim($train->getShaftEncoder4Speed()),
            'condition' => trim($train->getCondition()->getName()),
            'badge' => trim($train->getCondition()->getBadge()),
            'error' => trim($train->getErrorMessage()),
            'status' => trim($train->getStatus()->getName())
        );

        if($train->getTrain()){
            $feed['trainId'] = $train->getTrain()->getId();
            $feed['trainName'] = $train->getTrain()->getUnit();
        }

        try{
            $response = $this->guzzle->get('broadcast?'.http_build_query($feed));
            if(200 != (int)$response->getStatusCode()){
                $msg = "Service MotorCoachTransactionHandler publishFeed() failed to broadcast error:";
                $msg .= $response->getStatusCode();
                $this->logger->error($msg);
            }
        }catch(ClientException $e){
            $msg = "Service MotorCoachTransactionHandler publishFeed() ClientException:";
            $msg .= $e->getMessage();
            $this->logger->error($msg);
        }
        return;
    }
}
