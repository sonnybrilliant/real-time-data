<?php

namespace MlankaTech\AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * MotorCoach
 *
 * @ORM\Table(name="MOTOR_COACH",
 *  indexes={@ORM\Index(name="search_motor_coach", columns={"unit"})}
 * )
 *
 * @ORM\Entity(repositoryClass="MlankaTech\AppBundle\Entity\Repository\MotorCoachRepository")
 *
 * @Gedmo\Loggable
 * @Gedmo\SoftDeleteable(fieldName="deletedAt", timeAware=false)
 *
 *
 * @UniqueEntity(fields={"unit"}, groups={"create"}, message="Motor coach unit name is already being used, please try another one.")
 * @ORM\HasLifecycleCallbacks
 *
 * @author  Mfana Ronald Conco <ronald.conco@mlankatech.co.za>
 * @package MlankaTechAppBundle
 * @subpackage Entity
 * @version 0.0.1
 */
class MotorCoach
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
     * @var string
     *
     * @Assert\NotBlank(message = "Motor coach Unit name cannot be blank!",groups={"create"})
     * @Assert\Length(
     *      min = "2",
     *      max = "50",
     *      minMessage = "Motor coach Unit name must have at least {{ limit }} characters",
     *      maxMessage = "Motor coach Unit name has a limit of {{ limit }} characters",
     *      groups={"create","edit"}
     * )
     *
     * @ORM\Column(name="unit", type="string", length=50 ,unique=true)
     */
    private $unit;

    /**
     * @var boolean
     *
     * @ORM\Column(name="sort_order", type="integer", length=2)
     * @Gedmo\Versioned
     */
    protected $sortOrder = 0;

    /**
     * @Gedmo\Slug(fields={"unit"})
     * @ORM\Column(name="slug" , length=150 , unique=true)
     */
    protected $slug;

    /**
     * @var Type
     *
     * @ORM\ManyToOne(targetEntity="MlankaTech\AppBundle\Entity\MotorCoachType")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="type_id", referencedColumnName="id")
     * })
     * @Gedmo\Versioned
     */
    protected $type;

    /**
     * @var Train
     *
     * @ORM\ManyToOne(targetEntity="MlankaTech\AppBundle\Entity\Train")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="train_id", referencedColumnName="id")
     * })
     * @Gedmo\Versioned
     */
    protected $train;

    /**
     * @var Condition
     *
     * @ORM\ManyToOne(targetEntity="MlankaTech\AppBundle\Entity\Condition")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="condition_id", referencedColumnName="id")
     * })
     * @Gedmo\Versioned
     */
    protected $condition;

    /**
     * @var Status
     *
     * @ORM\ManyToOne(targetEntity="MlankaTech\AppBundle\Entity\Status")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="status_id", referencedColumnName="id")
     * })
     * @Gedmo\Versioned
     */
    protected $status;

    /**
     * @var boolean
     *
     * @ORM\Column(name="is_deleted", type="boolean")
     * @Gedmo\Versioned
     */
    protected $isDeleted = false;

    /**
     * @var boolean
     *
     * @ORM\Column(name="is_active", type="boolean")
     * @Gedmo\Versioned
     */
    protected $IsActive = true;

    /**
     *
     * @ORM\ManyToOne(targetEntity="MlankaTech\AppBundle\Entity\User")
     */
    protected $createdBy;

    /**
     *
     * @ORM\ManyToOne(targetEntity="MlankaTech\AppBundle\Entity\User")
     */
    protected $deletedBy;

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
     * @ORM\Column(name="deleted_at", type="datetime" , nullable=true)
     */
    protected $deletedAt;

    /**
     * @var datetime
     *
     * @ORM\Column(name="updated_at", type="datetime")
     * @Gedmo\Timestampable(on="update")
     * @link https://github.com/stof/StofDoctrineExtensionsBundle
     */
    protected $updatedAt;

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->unit;
    }

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
     * Set unit
     *
     * @param string $unit
     *
     * @return MotorCoach
     */
    public function setUnit($unit)
    {
        $this->unit = $unit;

        return $this;
    }

    /**
     * Get unit
     *
     * @return string
     */
    public function getUnit()
    {
        return $this->unit;
    }

    /**
     * Set sortOrder
     *
     * @param integer $sortOrder
     *
     * @return MotorCoach
     */
    public function setSortOrder($sortOrder)
    {
        $this->sortOrder = $sortOrder;

        return $this;
    }

    /**
     * Get sortOrder
     *
     * @return integer
     */
    public function getSortOrder()
    {
        return $this->sortOrder;
    }

    /**
     * Set slug
     *
     * @param string $slug
     *
     * @return MotorCoach
     */
    public function setSlug($slug)
    {
        $this->slug = $slug;

        return $this;
    }

    /**
     * Get slug
     *
     * @return string
     */
    public function getSlug()
    {
        return $this->slug;
    }

    /**
     * Set isDeleted
     *
     * @param boolean $isDeleted
     *
     * @return MotorCoach
     */
    public function setIsDeleted($isDeleted)
    {
        $this->isDeleted = $isDeleted;

        return $this;
    }

    /**
     * Get isDeleted
     *
     * @return boolean
     */
    public function getIsDeleted()
    {
        return $this->isDeleted;
    }

    /**
     * Set isActive
     *
     * @param boolean $isActive
     *
     * @return MotorCoach
     */
    public function setIsActive($isActive)
    {
        $this->IsActive = $isActive;

        return $this;
    }

    /**
     * Get isActive
     *
     * @return boolean
     */
    public function getIsActive()
    {
        return $this->IsActive;
    }

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     *
     * @return MotorCoach
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
     * Set deletedAt
     *
     * @param \DateTime $deletedAt
     *
     * @return MotorCoach
     */
    public function setDeletedAt($deletedAt)
    {
        $this->deletedAt = $deletedAt;

        return $this;
    }

    /**
     * Get deletedAt
     *
     * @return \DateTime
     */
    public function getDeletedAt()
    {
        return $this->deletedAt;
    }

    /**
     * Set updatedAt
     *
     * @param \DateTime $updatedAt
     *
     * @return MotorCoach
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
     * Set type
     *
     * @param \MlankaTech\AppBundle\Entity\MotorCoachType $type
     *
     * @return MotorCoach
     */
    public function setType(\MlankaTech\AppBundle\Entity\MotorCoachType $type = null)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Get type
     *
     * @return \MlankaTech\AppBundle\Entity\MotorCoachType
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Set train
     *
     * @param \MlankaTech\AppBundle\Entity\Train $train
     *
     * @return MotorCoach
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
     * Set condition
     *
     * @param \MlankaTech\AppBundle\Entity\Condition $condition
     *
     * @return MotorCoach
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
     * @return MotorCoach
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

    /**
     * Set createdBy
     *
     * @param \MlankaTech\AppBundle\Entity\User $createdBy
     *
     * @return MotorCoach
     */
    public function setCreatedBy(\MlankaTech\AppBundle\Entity\User $createdBy = null)
    {
        $this->createdBy = $createdBy;

        return $this;
    }

    /**
     * Get createdBy
     *
     * @return \MlankaTech\AppBundle\Entity\User
     */
    public function getCreatedBy()
    {
        return $this->createdBy;
    }

    /**
     * Set deletedBy
     *
     * @param \MlankaTech\AppBundle\Entity\User $deletedBy
     *
     * @return MotorCoach
     */
    public function setDeletedBy(\MlankaTech\AppBundle\Entity\User $deletedBy = null)
    {
        $this->deletedBy = $deletedBy;

        return $this;
    }

    /**
     * Get deletedBy
     *
     * @return \MlankaTech\AppBundle\Entity\User
     */
    public function getDeletedBy()
    {
        return $this->deletedBy;
    }
}
