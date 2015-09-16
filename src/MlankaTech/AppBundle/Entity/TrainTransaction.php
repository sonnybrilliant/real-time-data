<?php

namespace MlankaTech\AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * TrainTransaction
 *
 * @ORM\Table(name="TRAIN_TRANSACTION")
 *
 * @ORM\Entity(repositoryClass="MlankaTech\AppBundle\Entity\Repository\TrainTransactionRepository")
 *
 *
 * @author  Mfana Ronald Conco <ronald.conco@mlankatech.co.za>
 * @package MlankaTechAppBundle
 * @subpackage Entity
 * @version 0.0.1
 */
class TrainTransaction
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
     * Set trainName
     *
     * @param string $trainName
     * @return TrainTransaction
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
     * @return TrainTransaction
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
     * @return TrainTransaction
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
     * @return TrainTransaction
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
     * @return TrainTransaction
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
     * Set createdAt
     *
     * @param \DateTime $createdAt
     * @return TrainTransaction
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
     * @return TrainTransaction
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
     * Set train
     *
     * @param \MlankaTech\AppBundle\Entity\Train $train
     * @return TrainTransaction
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
     * Set trainType
     *
     * @param \MlankaTech\AppBundle\Entity\TrainType $trainType
     * @return TrainTransaction
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
     * @return TrainTransaction
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
     * @return TrainTransaction
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
