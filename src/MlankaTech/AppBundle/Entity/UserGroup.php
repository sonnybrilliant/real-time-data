<?php

namespace MlankaTech\AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * UserGroup
 *
 * @ORM\Table(name="USER_GROUP")
 * @ORM\Entity(repositoryClass="MlankaTech\AppBundle\Entity\Repository\UserGroupRepository")
 *
 * @author  Mfana Ronald Conco <ronald.conco@mlankatech.co.za>
 * @package MlankaTechAppBundle
 * @subpackage Entity
 * @version 0.0.1
 */
class UserGroup
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
     * @ORM\Column(name="name", type="string", length=50)
     */
    private $name;

    /**
     * @var ArrayCollection
     *
     * @ORM\ManyToMany(targetEntity="MlankaTech\AppBundle\Entity\Role")
     * @ORM\JoinTable(name="USER_GROUP_ROLE_MAP",
     * joinColumns={@ORM\JoinColumn(name="user_group_id", referencedColumnName="id")},
     * inverseJoinColumns={@ORM\JoinColumn(name="role_id", referencedColumnName="id")}
     * )
     */
    private $roles;

    /**
     * Class Construct
     *
     * @param $name
     */
    public function __construct($name)
    {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->name;
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
     * Set name
     *
     * @param string $name
     * @return UserGroup
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string 
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Add role
     *
     * @param \MlankaTech\AppBundle\Entity\Role $role
     * @return UserGroup
     */
    public function addRole(\MlankaTech\AppBundle\Entity\Role $role){
        $this->roles[] = $role;
        return $this;
    }

    /**
     * Remove role
     *
     * @param \MlankaTech\AppBundle\Entity\Role $role
     * @return UserGroup
     */
    public function removeRole(\MlankaTech\AppBundle\Entity\Role $role){
        $this->roles->removeElement($role);
        return $this;
    }

    /**
     * @return \Doctrine\Common\Collections\ArrayCollection
     */
    public function getRoles()
    {
        return $this->roles;
    }

}
