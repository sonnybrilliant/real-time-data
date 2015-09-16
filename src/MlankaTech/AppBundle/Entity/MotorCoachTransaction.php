<?php

namespace MlankaTech\AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * MotorCoachTransaction
 *
 * @ORM\Table(name="MOTOR_COACH_TRANSACTION")
 *
 * @ORM\Entity(repositoryClass="MlankaTech\AppBundle\Entity\Repository\MotorCoachTransactionRepository")
 *
 *
 * @author  Mfana Ronald Conco <ronald.conco@mlankatech.co.za>
 * @package MlankaTechAppBundle
 * @subpackage Entity
 * @version 0.0.1
 */
class MotorCoachTransaction
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     *
     * @ORM\ManyToOne(targetEntity="MlankaTech\AppBundle\Entity\MotorCoach")
     */
    protected $motorCoach;

    /**
     * @var string
     *
     * @ORM\Column(name="motor_couch_name", type="string", length=50 )
     */
    private $motorCoachName;

    /**
     *
     * @ORM\ManyToOne(targetEntity="MlankaTech\AppBundle\Entity\Train")
     */
    protected $train;

    /**
     * @var string
     *
     * @ORM\Column(name="train_name", type="string", length=50 )
     */
    private $trainName;

    /**
     * @var Motor Coach Type
     *
     * @ORM\ManyToOne(targetEntity="MlankaTech\AppBundle\Entity\MotorCoachType")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="motor_coach_type_id", referencedColumnName="id")
     * })
     */
    protected $motorCoachType;

    /**
     * @var Train Type
     *
     * @ORM\ManyToOne(targetEntity="MlankaTech\AppBundle\Entity\TrainType")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="train_type_id", referencedColumnName="id")
     * })
     */
    protected $trainType;

    /**
     * @var Condition
     *
     * @ORM\ManyToOne(targetEntity="MlankaTech\AppBundle\Entity\Condition")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="condition_id", referencedColumnName="id")
     * })
     */
    protected $condition;

    /**
     * @var Status
     *
     * @ORM\ManyToOne(targetEntity="MlankaTech\AppBundle\Entity\Status")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="status_id", referencedColumnName="id")
     * })
     */
    protected $status;

    /**
     * @var string
     *
     * @ORM\Column(name="gps_time", type="datetime")
     */
    private $gpsTime;

    /**
     * @var string
     *
     * @ORM\Column(name="latitude", type="string", length=50 )
     */
    private $latitude;

    /**
     * @var string
     *
     * @ORM\Column(name="longitude", type="string", length=50 )
     */
    private $longitude;

    /**
     * @var string
     *
     * @ORM\Column(name="gps_speed", type="string", length=50 )
     */
    private $gpsSpeed;

    /**
     * @var string
     *
     * @ORM\Column(name="ev_no", type="string", length=50 , nullable=true )
     */
    private $evNo;

    /**
     * @var string
     *
     * @ORM\Column(name="line_voltage", type="string", length=50 )
     */
    private $lineVoltage;

    /**
     * @var string
     *
     * @ORM\Column(name="ma_output_voltage", type="string", length=50 )
     */
    private $mAOutputVoltage;

    /**
     * @var string
     *
     * @ORM\Column(name="speedo", type="string", length=50 )
     */
    private $speedo;

    /**
     * @var string
     *
     * @ORM\Column(name="brake_vacuum", type="string", length=50 )
     */
    private $brakeVacuum;

    /**
     * @var string
     *
     * @ORM\Column(name="boggie_1_current", type="string", length=50 )
     */
    private $boggie1Current;

    /**
     * @var string
     *
     * @ORM\Column(name="boggie_2_current", type="string", length=50 )
     */
    private $boggie2Current;

    /**
     * @var string
     *
     * @ORM\Column(name="shaft_encoder_1_speed", type="string", length=50 )
     */
    private $shaftEncoder1Speed;

    /**
     * @var string
     *
     * @ORM\Column(name="shaft_encoder_2_speed", type="string", length=50 )
     */
    private $shaftEncoder2Speed;

    /**
     * @var string
     *
     * @ORM\Column(name="shaft_encoder_3_speed", type="string", length=50 )
     */
    private $shaftEncoder3Speed;

    /**
     * @var string
     *
     * @ORM\Column(name="shaft_encoder_4_speed", type="string", length=50 )
     */
    private $shaftEncoder4Speed;

    /**
     * @var string
     *
     * @ORM\Column(name="error_message", type="string", length=50 , nullable=true )
     */
    private $errorMessage;

    /**
     * @var datetime
     *
     * @Gedmo\Timestampable(on="create")
     * @ORM\Column(name="created_at", type="datetime")
     * @link https://github.com/stof/StofDoctrineExtensionsBundle
     */
    protected $createdAt;

    /**
     * @var datetime
     *
     * @ORM\Column(name="updated_at", type="datetime")
     * @Gedmo\Timestampable(on="update")
     * @link https://github.com/stof/StofDoctrineExtensionsBundle
     */
    protected $updatedAt;

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set motorCoachName
     *
     * @param string $motorCoachName
     *
     * @return MotorCoachTransaction
     */
    public function setMotorCoachName($motorCoachName)
    {
        $this->motorCoachName = $motorCoachName;

        return $this;
    }

    /**
     * Get motorCoachName
     *
     * @return string
     */
    public function getMotorCoachName()
    {
        return $this->motorCoachName;
    }

    /**
     * Set trainName
     *
     * @param string $trainName
     *
     * @return MotorCoachTransaction
     */
    public function setTrainName($trainName)
    {
        $this->trainName = $trainName;

        return $this;
    }

    /**
     * Get trainName
     *
     * @return string
     */
    public function getTrainName()
    {
        return $this->trainName;
    }

    /**
     * Set gpsTime
     *
     * @param \DateTime $gpsTime
     *
     * @return MotorCoachTransaction
     */
    public function setGpsTime($gpsTime)
    {
        $this->gpsTime = $gpsTime;

        return $this;
    }

    /**
     * Get gpsTime
     *
     * @return \DateTime
     */
    public function getGpsTime()
    {
        return $this->gpsTime;
    }

    /**
     * Set latitude
     *
     * @param string $latitude
     *
     * @return MotorCoachTransaction
     */
    public function setLatitude($latitude)
    {
        $this->latitude = $latitude;

        return $this;
    }

    /**
     * Get latitude
     *
     * @return string
     */
    public function getLatitude()
    {
        return $this->latitude;
    }

    /**
     * Set longitude
     *
     * @param string $longitude
     *
     * @return MotorCoachTransaction
     */
    public function setLongitude($longitude)
    {
        $this->longitude = $longitude;

        return $this;
    }

    /**
     * Get longitude
     *
     * @return string
     */
    public function getLongitude()
    {
        return $this->longitude;
    }

    /**
     * Set gpsSpeed
     *
     * @param string $gpsSpeed
     *
     * @return MotorCoachTransaction
     */
    public function setGpsSpeed($gpsSpeed)
    {
        $this->gpsSpeed = $gpsSpeed;

        return $this;
    }

    /**
     * Get gpsSpeed
     *
     * @return string
     */
    public function getGpsSpeed()
    {
        return $this->gpsSpeed;
    }

    /**
     * Set evNo
     *
     * @param string $evNo
     *
     * @return MotorCoachTransaction
     */
    public function setEvNo($evNo)
    {
        $this->evNo = $evNo;

        return $this;
    }

    /**
     * Get evNo
     *
     * @return string
     */
    public function getEvNo()
    {
        return $this->evNo;
    }

    /**
     * Set lineVoltage
     *
     * @param string $lineVoltage
     *
     * @return MotorCoachTransaction
     */
    public function setLineVoltage($lineVoltage)
    {
        $this->lineVoltage = $lineVoltage;

        return $this;
    }

    /**
     * Get lineVoltage
     *
     * @return string
     */
    public function getLineVoltage()
    {
        return $this->lineVoltage;
    }

    /**
     * Set mAOutputVoltage
     *
     * @param string $mAOutputVoltage
     *
     * @return MotorCoachTransaction
     */
    public function setMAOutputVoltage($mAOutputVoltage)
    {
        $this->mAOutputVoltage = $mAOutputVoltage;

        return $this;
    }

    /**
     * Get mAOutputVoltage
     *
     * @return string
     */
    public function getMAOutputVoltage()
    {
        return $this->mAOutputVoltage;
    }

    /**
     * Set speedo
     *
     * @param string $speedo
     *
     * @return MotorCoachTransaction
     */
    public function setSpeedo($speedo)
    {
        $this->speedo = $speedo;

        return $this;
    }

    /**
     * Get speedo
     *
     * @return string
     */
    public function getSpeedo()
    {
        return $this->speedo;
    }

    /**
     * Set brakeVacuum
     *
     * @param string $brakeVacuum
     *
     * @return MotorCoachTransaction
     */
    public function setBrakeVacuum($brakeVacuum)
    {
        $this->brakeVacuum = $brakeVacuum;

        return $this;
    }

    /**
     * Get brakeVacuum
     *
     * @return string
     */
    public function getBrakeVacuum()
    {
        return $this->brakeVacuum;
    }

    /**
     * Set boggie1Current
     *
     * @param string $boggie1Current
     *
     * @return MotorCoachTransaction
     */
    public function setBoggie1Current($boggie1Current)
    {
        $this->boggie1Current = $boggie1Current;

        return $this;
    }

    /**
     * Get boggie1Current
     *
     * @return string
     */
    public function getBoggie1Current()
    {
        return $this->boggie1Current;
    }

    /**
     * Set boggie2Current
     *
     * @param string $boggie2Current
     *
     * @return MotorCoachTransaction
     */
    public function setBoggie2Current($boggie2Current)
    {
        $this->boggie2Current = $boggie2Current;

        return $this;
    }

    /**
     * Get boggie2Current
     *
     * @return string
     */
    public function getBoggie2Current()
    {
        return $this->boggie2Current;
    }

    /**
     * Set shaftEncoder1Speed
     *
     * @param string $shaftEncoder1Speed
     *
     * @return MotorCoachTransaction
     */
    public function setShaftEncoder1Speed($shaftEncoder1Speed)
    {
        $this->shaftEncoder1Speed = $shaftEncoder1Speed;

        return $this;
    }

    /**
     * Get shaftEncoder1Speed
     *
     * @return string
     */
    public function getShaftEncoder1Speed()
    {
        return $this->shaftEncoder1Speed;
    }

    /**
     * Set shaftEncoder2Speed
     *
     * @param string $shaftEncoder2Speed
     *
     * @return MotorCoachTransaction
     */
    public function setShaftEncoder2Speed($shaftEncoder2Speed)
    {
        $this->shaftEncoder2Speed = $shaftEncoder2Speed;

        return $this;
    }

    /**
     * Get shaftEncoder2Speed
     *
     * @return string
     */
    public function getShaftEncoder2Speed()
    {
        return $this->shaftEncoder2Speed;
    }

    /**
     * Set shaftEncoder3Speed
     *
     * @param string $shaftEncoder3Speed
     *
     * @return MotorCoachTransaction
     */
    public function setShaftEncoder3Speed($shaftEncoder3Speed)
    {
        $this->shaftEncoder3Speed = $shaftEncoder3Speed;

        return $this;
    }

    /**
     * Get shaftEncoder3Speed
     *
     * @return string
     */
    public function getShaftEncoder3Speed()
    {
        return $this->shaftEncoder3Speed;
    }

    /**
     * Set shaftEncoder4Speed
     *
     * @param string $shaftEncoder4Speed
     *
     * @return MotorCoachTransaction
     */
    public function setShaftEncoder4Speed($shaftEncoder4Speed)
    {
        $this->shaftEncoder4Speed = $shaftEncoder4Speed;

        return $this;
    }

    /**
     * Get shaftEncoder4Speed
     *
     * @return string
     */
    public function getShaftEncoder4Speed()
    {
        return $this->shaftEncoder4Speed;
    }

    /**
     * Set errorMessage
     *
     * @param string $errorMessage
     *
     * @return MotorCoachTransaction
     */
    public function setErrorMessage($errorMessage)
    {
        $this->errorMessage = $errorMessage;

        return $this;
    }

    /**
     * Get errorMessage
     *
     * @return string
     */
    public function getErrorMessage()
    {
        return $this->errorMessage;
    }

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     *
     * @return MotorCoachTransaction
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * Get createdAt
     *
     * @return \DateTime
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * Set updatedAt
     *
     * @param \DateTime $updatedAt
     *
     * @return MotorCoachTransaction
     */
    public function setUpdatedAt($updatedAt)
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    /**
     * Get updatedAt
     *
     * @return \DateTime
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    /**
     * Set motorCoach
     *
     * @param \MlankaTech\AppBundle\Entity\MotorCoach $motorCoach
     *
     * @return MotorCoachTransaction
     */
    public function setMotorCoach(\MlankaTech\AppBundle\Entity\MotorCoach $motorCoach = null)
    {
        $this->motorCoach = $motorCoach;

        return $this;
    }

    /**
     * Get motorCoach
     *
     * @return \MlankaTech\AppBundle\Entity\MotorCoach
     */
    public function getMotorCoach()
    {
        return $this->motorCoach;
    }

    /**
     * Set train
     *
     * @param \MlankaTech\AppBundle\Entity\Train $train
     *
     * @return MotorCoachTransaction
     */
    public function setTrain(\MlankaTech\AppBundle\Entity\Train $train = null)
    {
        $this->train = $train;

        return $this;
    }

    /**
     * Get train
     *
     * @return \MlankaTech\AppBundle\Entity\Train
     */
    public function getTrain()
    {
        return $this->train;
    }

    /**
     * Set motorCoachType
     *
     * @param \MlankaTech\AppBundle\Entity\MotorCoachType $motorCoachType
     *
     * @return MotorCoachTransaction
     */
    public function setMotorCoachType(\MlankaTech\AppBundle\Entity\MotorCoachType $motorCoachType = null)
    {
        $this->motorCoachType = $motorCoachType;

        return $this;
    }

    /**
     * Get motorCoachType
     *
     * @return \MlankaTech\AppBundle\Entity\MotorCoachType
     */
    public function getMotorCoachType()
    {
        return $this->motorCoachType;
    }

    /**
     * Set trainType
     *
     * @param \MlankaTech\AppBundle\Entity\TrainType $trainType
     *
     * @return MotorCoachTransaction
     */
    public function setTrainType(\MlankaTech\AppBundle\Entity\TrainType $trainType = null)
    {
        $this->trainType = $trainType;

        return $this;
    }

    /**
     * Get trainType
     *
     * @return \MlankaTech\AppBundle\Entity\TrainType
     */
    public function getTrainType()
    {
        return $this->trainType;
    }

    /**
     * Set condition
     *
     * @param \MlankaTech\AppBundle\Entity\Condition $condition
     *
     * @return MotorCoachTransaction
     */
    public function setCondition(\MlankaTech\AppBundle\Entity\Condition $condition = null)
    {
        $this->condition = $condition;

        return $this;
    }

    /**
     * Get condition
     *
     * @return \MlankaTech\AppBundle\Entity\Condition
     */
    public function getCondition()
    {
        return $this->condition;
    }

    /**
     * Set status
     *
     * @param \MlankaTech\AppBundle\Entity\Status $status
     *
     * @return MotorCoachTransaction
     */
    public function setStatus(\MlankaTech\AppBundle\Entity\Status $status = null)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * Get status
     *
     * @return \MlankaTech\AppBundle\Entity\Status
     */
    public function getStatus()
    {
        return $this->status;
    }
}
