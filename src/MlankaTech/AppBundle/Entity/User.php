<?php

namespace MlankaTech\AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Security\Core\User\AdvancedUserInterface;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * MlankaTech\AppBundle\Entity\User
 *
 * @ORM\Entity(repositoryClass="MlankaTech\AppBundle\Entity\Repository\UserRepository")
 *
 * @ORM\Table(name="USER",
 *      indexes={@ORM\Index(name="search_context", columns={"first_name","last_name"})}
 * )
 *
 * @UniqueEntity(fields={"email"}, groups={"create"}, message="Email address is already being used by another user, please try another one.")
 * @ORM\HasLifecycleCallbacks
 *
 * @Gedmo\Loggable
 * @Gedmo\SoftDeleteable(fieldName="deletedAt", timeAware=false)
 *
 * @author Mfana Ronald Conco <ronald.conco@mlankatech.co.za>
 * @package MlankaAppBundle
 * @subpackage Entity
 * @version 0.0.1
 *
 */
class User implements AdvancedUserInterface, \Serializable
{

    /**
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     * @var integer
     */
    protected $id;

    /**
     * @var string
     *
     * @Assert\NotBlank(message = "First name cannot be blank!",groups={"create","edit"})
     * @Assert\Length(
     *      min = "2",
     *      max = "100",
     *      minMessage = "First name must have at least {{ limit }} characters",
     *      maxMessage = "First name has a limit of {{ limit }} characters",
     *      groups={"create","edit"}
     * )
     * @Assert\Regex(pattern="/\d/",
     *               match=false,
     *               message="First Name cannot contain numeric values",
     *               groups={"create","edit"}
     *  )
     *
     * @ORM\Column(name="first_name", type="string", length=50)
     * @Gedmo\Versioned
     */
    protected $firstName;

    /**
     * @var string
     *
     * @Assert\NotBlank(message = "Surname cannot be blank!",groups={"create","edit"})
     * @Assert\Length(
     *      min = "2",
     *      max = "100",
     *      minMessage = "Surname must have at least {{ limit }} characters",
     *      maxMessage = "Surname has a limit of {{ limit }} characters",
     *      groups={"create","edit"}
     * )
     * @Assert\Regex(pattern="/\d/",
     *               match=false,
     *               message="Last Name cannot contain numeric values",
     *               groups={"create","edit"}
     *  )
     *
     * @ORM\Column(name="last_name", type="string", length=50)
     * @Gedmo\Versioned
     */
    protected $lastName;

    /**
     * @var string
     *
     */
    protected $fullName;

    /**
     * @Gedmo\Slug(fields={"firstName","lastName"})
     * @ORM\Column(name="slug" , length=150 , unique=true)
     */
    protected $slug;

    /**
     * @var string
     *
     * @Assert\NotBlank(message = "Email cannot be blank!",groups={"create"})
     * @Assert\Email(
     *   message = "The email '{{ value }}' is not a valid email.",
     *   checkMX = false,
     *   groups={"create"}
     * )
     *
     * @ORM\Column(name="email", type="string", length=254 , unique=true)
     * @Gedmo\Versioned
     */
    protected $email;

    /**
     * @var string
     *
     * @Assert\NotBlank(message = "Password cannot be blank!")
     * @Assert\Length(
     *      min = "6",
     *      max = "20",
     *      minMessage = "Password must have at least {{ limit }} characters",
     *      maxMessage = "Password has a limit of {{ limit }} characters",
     *      groups={"create"}
     * )
     *
     * @ORM\Column(name="password", type="string", length=255)
     * @Gedmo\Versioned
     */
    protected $password;

    /**
     * @var string
     * @ORM\Column(name="forgot_password", type="string", length=255 , nullable=true)
     * @Gedmo\Versioned
     */
    protected $forgotPassword;

    /**
     * @var salt
     *
     */
    protected $salt;

    /**
     * @var ArrayCollection
     *
     * @ORM\ManyToMany(targetEntity="MlankaTech\AppBundle\Entity\Role",inversedBy="users")
     * @ORM\JoinTable(name="USER_ROLE_MAP",
     *     joinColumns={@ORM\JoinColumn(name="user_id", referencedColumnName="id")},
     *     inverseJoinColumns={@ORM\JoinColumn(name="role_id", referencedColumnName="id")}
     * )
     *
     */
    protected $userRoles;

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
    protected $deleted = false;

    /**
     * @var Status
     *
     * @ORM\ManyToOne(targetEntity="MlankaTech\AppBundle\Entity\UserGroup")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="group_id", referencedColumnName="id")
     * })
     * @Gedmo\Versioned
     */
    protected $group;

    /**
     * @var Title
     *
     * @ORM\ManyToOne(targetEntity="MlankaTech\AppBundle\Entity\Title")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="title_id", referencedColumnName="id")
     * })
     * @Gedmo\Versioned
     */
    protected $title;

    /**
     * @var Gender
     *
     * @ORM\ManyToOne(targetEntity="MlankaTech\AppBundle\Entity\Gender")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="gender_id", referencedColumnName="id")
     * })
     * @Gedmo\Versioned
     */
    protected $gender;

    /**
     * @var boolean
     *
     * @ORM\Column(name="is_admin", type="boolean")
     * @Gedmo\Versioned
     */
    protected $admin = false;

    /**
     * @var boolean
     *
     * @ORM\Column(name="is_active", type="boolean")
     * @Gedmo\Versioned
     */
    protected $active = true;

    /**
     * @var boolean
     *
     * @ORM\Column(name="is_expired", type="boolean")
     * @Gedmo\Versioned
     */
    protected $expired = false;

    /**
     * @var boolean
     *
     * @ORM\Column(name="is_locked", type="boolean")
     * @Gedmo\Versioned
     */
    protected $locked = false;

    /**
     * @var datetime
     *
     * @ORM\Column(name="last_login", type="datetime" , nullable= true)
     */
    protected $lastLogin;

    /**
     * @var datetime
     *
     * @ORM\Column(name="expires_at", type="datetime" , nullable= true)
     */
    protected $expiresAt;

    /**
     * @var string
     *
     * @ORM\Column(name="confirmation_token", type="string" , length=254 ,nullable= true)
     */
    protected $confirmationToken;

    /**
     *
     * @var String
     */
    protected $transient;

    /**
     * @var datetime
     *
     * @ORM\Column(name="password_requested_at", type="datetime" , nullable= true)
     */
    protected $passwordRequestedAt;

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
     * @var User
     * @ORM\ManyToOne(targetEntity="MlankaTech\AppBundle\Entity\User")
     */
    private $suspendedBy;

    /**
     * @var User
     * @ORM\ManyToOne(targetEntity="MlankaTech\AppBundle\Entity\User")
     */
    private $activatedBy;

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
     * @var \DateTime
     *
     * @ORM\Column(name="suspend_at", type="datetime", nullable=true)
     */
    private $suspendAt;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="activated_at", type="datetime", nullable=true)
     */
    private $activatedAt;

    /**
     * Class construct
     *
     */
    public function __construct()
    {
        $this->userRoles = new ArrayCollection();
    }

    public function __toString()
    {
        return $this->firstName . ' ' . $this->lastName;
    }

    /**
     * Removes sensitive data from the user.
     *
     * This is important if, at any given point, sensitive information like
     * the plain-text password is stored on this object.
     */
    public function eraseCredentials()
    {

    }

    /**
     * Returns the roles granted to the user.
     *
     * <code>
     * public function getRoles()
     * {
     *     return array('ROLE_USER');
     * }
     * </code>
     *
     * Alternatively, the roles might be stored on a ``roles`` property,
     * and populated in any number of different ways when the user object
     * is created.
     *
     * @return Role[] The user roles
     */
    public function getRoles()
    {
        return $this->getUserRoles()->toArray();
    }


    /**
     * Compares this user to another to determine if they are the same.
     *
     * @param AdvancedUserInterface $user
     * @return bool
     */
    public function isEqualTo(AdvancedUserInterface $user)
    {
        return $this->email === $user->getUsername();
    }

    /**
     * @ORM\PrePersist()
     */
    public function finalizeUser()
    {
        if (null === $this->getExpiresAt()) {
            $date = new \DateTime();
            $this->setExpiresAt($date->modify('+6 months'));
        }
    }

    /**
     * (PHP 5 &gt;= 5.1.0)<br/>
     * String representation of object
     * @link http://php.net/manual/en/serializable.serialize.php
     * @return string the string representation of the object or null
     */
    public function serialize()
    {
        return serialize(array(
            $this->id,
            $this->firstName,
            $this->lastName,
            $this->email,
        ));
    }

    /**
     * (PHP 5 &gt;= 5.1.0)<br/>
     * Constructs the object
     * @link http://php.net/manual/en/serializable.unserialize.php
     * @param string $serialized <p>
     * The string representation of the object.
     * </p>
     * @return void
     */
    public function unserialize($serialized)
    {
        list (
            $this->id,
            $this->firstName,
            $this->lastName,
            $this->email,
            ) = unserialize($serialized);
    }

    /**
     * Returns the salt that was originally used to encode the password.
     *
     * This can return null if the password was not encoded using a salt.
     *
     * @return string|null The salt
     */
    public function getSalt()
    {
        return $this->salt;
    }

    /**
     * Returns the password used to authenticate the user.
     *
     * This should be the encoded password. On authentication, a plain-text
     * password will be salted, encoded, and then compared to this value.
     *
     * @return string The password
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * Checks whether the user's account has expired.
     *
     * Internally, if this method returns false, the authentication system
     * will throw an AccountExpiredException and prevent login.
     *
     * @return bool    true if the user's account is non expired, false otherwise
     *
     * @see AccountExpiredException
     */
    public function isAccountNonExpired()
    {
        return $this->expired?false:true;
    }

    /**
     * Checks whether the user is locked.
     *
     * Internally, if this method returns false, the authentication system
     * will throw a LockedException and prevent login.
     *
     * @return bool    true if the user is not locked, false otherwise
     *
     * @see LockedException
     */
    public function isAccountNonLocked()
    {
        return $this->locked?false:true;
    }

    /**
     * Checks whether the user's credentials (password) has expired.
     *
     * Internally, if this method returns false, the authentication system
     * will throw a CredentialsExpiredException and prevent login.
     *
     * @return bool    true if the user's credentials are non expired, false otherwise
     *
     * @see CredentialsExpiredException
     */
    public function isCredentialsNonExpired()
    {
        return $this->locked?false:true;
    }

    /**
     * Checks whether the user is enabled.
     *
     * Internally, if this method returns false, the authentication system
     * will throw a DisabledException and prevent login.
     *
     * @return bool    true if the user is enabled, false otherwise
     *
     * @see DisabledException
     */
    public function isEnabled()
    {
        return $this->active;
    }

    /**
     * set transient
     *
     * @param $transient
     * @return $this
     */
    public function setTransient($transient)
    {
        $this->transient = $transient;

        return $this;
    }

    /**
     * get transient
     * @return String
     */
    public function getTransient()
    {
        return $this->transient;
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
     * Set id
     *
     * @param Integer $id
     * @return User
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }


    /**
     * Concat first and last name
     *
     * @return string
     */
    public function getFullName()
    {
        $this->fullName = ucfirst($this->getFirstName()).' '.ucfirst($this->getLastName());
        return $this->fullName;
    }

    /**
     * Get username
     *
     * @return string
     */
    public function getUsername()
    {
        return $this->email;
    }

    /**
     * Set firstName
     *
     * @param string $firstName
     * @return User
     */
    public function setFirstName($firstName)
    {
        $this->firstName = $firstName;

        return $this;
    }

    /**
     * Get firstName
     *
     * @return string
     */
    public function getFirstName()
    {
        return $this->firstName;
    }

    /**
     * Set lastName
     *
     * @param string $lastName
     * @return User
     */
    public function setLastName($lastName)
    {
        $this->lastName = $lastName;

        return $this;
    }

    /**
     * Get lastName
     *
     * @return string
     */
    public function getLastName()
    {
        return $this->lastName;
    }

    /**
     * Set slug
     *
     * @param string $slug
     * @return User
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
     * Set email
     *
     * @param string $email
     * @return User
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get email
     *
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set password
     *
     * @param string $password
     * @return User
     */
    public function setPassword($password)
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Set salt
     *
     * @param string $salt
     * @return User
     */
    public function setSalt($salt)
    {
        $this->salt = $salt;

        return $this;
    }

    /**
     * Set lastLogin
     *
     * @param \DateTime $lastLogin
     * @return User
     */
    public function setLastLogin($lastLogin)
    {
        $this->lastLogin = $lastLogin;

        return $this;
    }

    /**
     * Get lastLogin
     *
     * @return \DateTime
     */
    public function getLastLogin()
    {
        return $this->lastLogin;
    }

    /**
     * Set expiresAt
     *
     * @param \DateTime $expiresAt
     * @return User
     */
    public function setExpiresAt($expiresAt)
    {
        $this->expiresAt = $expiresAt;

        return $this;
    }

    /**
     * Get expiresAt
     *
     * @return \DateTime
     */
    public function getExpiresAt()
    {
        return $this->expiresAt;
    }

    /**
     * Set confirmationToken
     *
     * @param string $confirmationToken
     * @return User
     */
    public function setConfirmationToken($confirmationToken)
    {
        $this->confirmationToken = $confirmationToken;

        return $this;
    }

    /**
     * Get confirmationToken
     *
     * @return string
     */
    public function getConfirmationToken()
    {
        return $this->confirmationToken;
    }

    /**
     * Set passwordRequestedAt
     *
     * @param \DateTime $passwordRequestedAt
     * @return User
     */
    public function setPasswordRequestedAt($passwordRequestedAt)
    {
        $this->passwordRequestedAt = $passwordRequestedAt;

        return $this;
    }

    /**
     * Get passwordRequestedAt
     *
     * @return \DateTime
     */
    public function getPasswordRequestedAt()
    {
        return $this->passwordRequestedAt;
    }

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     * @return User
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
     * @return User
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
     * @return User
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
     * Add userRoles
     *
     * @param \MlankaTech\AppBundle\Entity\Role $userRoles
     * @return User
     */
    public function addUserRole(\MlankaTech\AppBundle\Entity\Role $userRoles)
    {
        $this->userRoles[] = $userRoles;

        return $this;
    }

    /**
     * Remove userRoles
     *
     * @param \MlankaTech\AppBundle\Entity\Role $userRoles
     */
    public function removeUserRole(\MlankaTech\AppBundle\Entity\Role $userRoles)
    {
        $this->userRoles->removeElement($userRoles);
    }

    /**
     * Get userRoles
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getUserRoles()
    {
        return $this->userRoles;
    }

    /**
     * Set status
     *
     * @param \MlankaTech\AppBundle\Entity\Status $status
     * @return User
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
     * Set group
     *
     * @param \MlankaTech\AppBundle\Entity\UserGroup $group
     * @return User
     */
    public function setGroup(\MlankaTech\AppBundle\Entity\UserGroup $group = null)
    {
        $this->group = $group;

        return $this;
    }

    /**
     * Get group
     *
     * @return \MlankaTech\AppBundle\Entity\Group
     */
    public function getGroup()
    {
        return $this->group;
    }

    /**
     * Set title
     *
     * @param \MlankaTech\AppBundle\Entity\Title $title
     * @return User
     */
    public function setTitle(\MlankaTech\AppBundle\Entity\Title $title = null)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get title
     *
     * @return \MlankaTech\AppBundle\Entity\Title
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set gender
     *
     * @param \MlankaTech\AppBundle\Entity\Gender $gender
     * @return User
     */
    public function setGender(\MlankaTech\AppBundle\Entity\Gender $gender = null)
    {
        $this->gender = $gender;

        return $this;
    }

    /**
     * Get gender
     *
     * @return \MlankaTech\AppBundle\Entity\Gender
     */
    public function getGender()
    {
        return $this->gender;
    }

    /**
     * Set createdBy
     *
     * @param \MlankaTech\AppBundle\Entity\User $createdBy
     * @return User
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
     * @return User
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
     * Set admin
     *
     * @param boolean $admin
     *
     * @return User
     */
    public function setAdmin($admin)
    {
        $this->admin = $admin;

        return $this;
    }

    /**
     * Get admin
     *
     * @return boolean
     */
    public function getAdmin()
    {
        return $this->admin;
    }

    /**
     * Set active
     *
     * @param boolean $active
     *
     * @return User
     */
    public function setActive($active)
    {
        $this->active = $active;

        return $this;
    }

    /**
     * Get active
     *
     * @return boolean
     */
    public function getActive()
    {
        return $this->active;
    }

    /**
     * Set expired
     *
     * @param boolean $expired
     *
     * @return User
     */
    public function setExpired($expired)
    {
        $this->expired = $expired;

        return $this;
    }

    /**
     * Get expired
     *
     * @return boolean
     */
    public function getExpired()
    {
        return $this->expired;
    }

    /**
     * Set locked
     *
     * @param boolean $locked
     *
     * @return User
     */
    public function setLocked($locked)
    {
        $this->locked = $locked;

        return $this;
    }

    /**
     * Get locked
     *
     * @return boolean
     */
    public function getLocked()
    {
        return $this->locked;
    }

    /**
     * Set deleted
     *
     * @param boolean $deleted
     *
     * @return User
     */
    public function setDeleted($deleted)
    {
        $this->deleted = $deleted;

        return $this;
    }

    /**
     * Get deleted
     *
     * @return boolean
     */
    public function getDeleted()
    {
        return $this->deleted;
    }

    /**
     * Set forgotPassword
     *
     * @param string $forgotPassword
     *
     * @return User
     */
    public function setForgotPassword($forgotPassword)
    {
        $this->forgotPassword = $forgotPassword;

        return $this;
    }

    /**
     * Get forgotPassword
     *
     * @return string
     */
    public function getForgotPassword()
    {
        return $this->forgotPassword;
    }

    /**
     * Set suspendAt
     *
     * @param \DateTime $suspendAt
     *
     * @return User
     */
    public function setSuspendAt($suspendAt)
    {
        $this->suspendAt = $suspendAt;

        return $this;
    }

    /**
     * Get suspendAt
     *
     * @return \DateTime
     */
    public function getSuspendAt()
    {
        return $this->suspendAt;
    }

    /**
     * Set activatedAt
     *
     * @param \DateTime $activatedAt
     *
     * @return User
     */
    public function setActivatedAt($activatedAt)
    {
        $this->activatedAt = $activatedAt;

        return $this;
    }

    /**
     * Get activatedAt
     *
     * @return \DateTime
     */
    public function getActivatedAt()
    {
        return $this->activatedAt;
    }

    /**
     * Set suspendedBy
     *
     * @param \MlankaTech\AppBundle\Entity\User $suspendedBy
     *
     * @return User
     */
    public function setSuspendedBy(\MlankaTech\AppBundle\Entity\User $suspendedBy = null)
    {
        $this->suspendedBy = $suspendedBy;

        return $this;
    }

    /**
     * Get suspendedBy
     *
     * @return \MlankaTech\AppBundle\Entity\User
     */
    public function getSuspendedBy()
    {
        return $this->suspendedBy;
    }

    /**
     * Set activatedBy
     *
     * @param \MlankaTech\AppBundle\Entity\User $activatedBy
     *
     * @return User
     */
    public function setActivatedBy(\MlankaTech\AppBundle\Entity\User $activatedBy = null)
    {
        $this->activatedBy = $activatedBy;

        return $this;
    }

    /**
     * Get activatedBy
     *
     * @return \MlankaTech\AppBundle\Entity\User
     */
    public function getActivatedBy()
    {
        return $this->activatedBy;
    }
}
