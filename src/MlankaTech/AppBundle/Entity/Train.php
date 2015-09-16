<?php

namespace MlankaTech\AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * Role
 *
 * @ORM\Table(name="TRAIN",
 *   indexes={@ORM\Index(name="search_train", columns={"unit"})}
 * )
 *
 * @ORM\Entity(repositoryClass="MlankaTech\AppBundle\Entity\Repository\TrainRepository")
 *
 * @UniqueEntity(fields={"unit"}, groups={"create"}, message="Train unit name is already being used, please try another one.")
 * @ORM\HasLifecycleCallbacks
 *
 * @Gedmo\Loggable
 * @Gedmo\SoftDeleteable(fieldName="deletedAt", timeAware=false)
 *
 * @author  Mfana Ronald Conco <ronald.conco@mlankatech.co.za>
 * @package MlankaTechAppBundle
 * @subpackage Entity
 * @version 0.0.1
 */
class Train
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
     * @Assert\NotBlank(message = "Train Unit name cannot be blank!",groups={"create"})
     * @Assert\Length(
     *      min = "2",
     *      max = "50",
     *      minMessage = "Train Unit name must have at least {{ limit }} characters",
     *      maxMessage = "Train Unit name has a limit of {{ limit }} characters",
     *      groups={"create","edit"}
     * )
     *
     * @ORM\Column(name="unit", type="string", length=50 ,unique=true)
     */
    private $unit;

    /**
     * @var Type
     *
     * @ORM\ManyToOne(targetEntity="MlankaTech\AppBundle\Entity\TrainType")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="type_id", referencedColumnName="id")
     * })
     * @Gedmo\Versioned
     */
    protected $type;

    /**
     * @Gedmo\Slug(fields={"unit"})
     * @ORM\Column(name="slug" , length=150 , unique=true)
     */
    protected $slug;

    /**
     * @var ArrayCollection
     *
     * @ORM\ManyToMany(targetEntity="MlankaTech\AppBundle\Entity\MotorCoach")
     * @ORM\JoinTable(name="TRAIN_MOTOR_COACH_MAP",
     * joinColumns={@ORM\JoinColumn(name="train_id", referencedColumnName="id")},
     * inverseJoinColumns={@ORM\JoinColumn(name="motor_coach_id", referencedColumnName="id")}
     * )
     */
    private $motorcoaches;

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
     * Constructor
     */
    public function __construct()
    {
        $this->motorcoaches = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set unit
     *
     * @param string $unit
     * @return Train
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
     * Set isDeleted
     *
     * @param boolean $isDeleted
     * @return Train
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
     * Set IsActive
     *
     * @param boolean $isActive
     * @return Train
     */
    public function setIsActive($isActive)
    {
        $this->IsActive = $isActive;

        return $this;
    }

    /**
     * Get IsActive
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
     * @return Train
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
     * @return Train
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
     * @return Train
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
     * Add motorcoaches
     *
     * @param \MlankaTech\AppBundle\Entity\MotorCoach $motorcoaches
     * @return Train
     */
    public function addMotorcoach(\MlankaTech\AppBundle\Entity\MotorCoach $motorcoaches)
    {
        $this->motorcoaches[] = $motorcoaches;

        return $this;
    }

    /**
     * Remove motorcoaches
     *
     * @param \MlankaTech\AppBundle\Entity\MotorCoach $motorcoaches
     */
    public function removeMotorcoach(\MlankaTech\AppBundle\Entity\MotorCoach $motorcoaches)
    {
        $this->motorcoaches->removeElement($motorcoaches);
    }

    /**
     * Get motorcoaches
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getMotorcoaches()
    {
        return $this->motorcoaches;
    }

    /**
     * Set status
     *
     * @param \MlankaTech\AppBundle\Entity\Status $status
     * @return Train
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
     * Set condition
     *
     * @param \MlankaTech\AppBundle\Entity\Condition $condition
     * @return Train
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
     * Set createdBy
     *
     * @param \MlankaTech\AppBundle\Entity\User $createdBy
     * @return Train
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
     * @return Train
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

    /**
     * Set slug
     *
     * @param string $slug
     * @return Train
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
     * Set type
     *
     * @param \MlankaTech\AppBundle\Entity\TrainType $type
     * @return Train
     */
    public function setType(\MlankaTech\AppBundle\Entity\TrainType $type = null)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Get type
     *
     * @return \MlankaTech\AppBundle\Entity\TrainType
     */
    public function getType()
    {
        return $this->type;
    }
}
