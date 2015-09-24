<?php

namespace MlankaTech\AppBundle\Services\User;

use Doctrine\ORM\EntityManager;
use MlankaTech\AppBundle\Entity\User;
use JMS\DiExtraBundle\Annotation as DI;
use JMS\DiExtraBundle\Annotation\Inject;
use MlankaTech\AppBundle\Services\Core\StatusManager;
use MlankaTech\AppBundle\Event\User\UserEvents;
use MlankaTech\AppBundle\Event\User\UserEvent;
use MlankaTech\AppBundle\Services\Core\UserGroupManager;
use Symfony\Component\Security\Core\Encoder\EncoderFactory;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Monolog\Logger;

/**
 * UserManager
 *
 * @DI\Service("user.manager")
 * @author  Mfana Ronald Conco <ronald.conco@mlankatech.co.za>
 * @package MlankaTechAppBundle
 * @subpackage Services
 * @version 0.0.1
 *
 */
class UserManager
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
     * UserGroupManager.
     *
     * @var Service
     */
    protected $userGroupManager;

    /**
     * Security Storage Token
     * @var object
     * @Inject("security.token_storage", required = false)
     */
    public $securityTokenStorage;

    /**
     * @var Event Dispatcher
     */
    private $eventDispatcher;

    /**
     * @var EncoderFactory
     */
    private $encoderFactory;

    /**
     *
     * Class construct
     *
     * @param EntityManager $em
     * @param UserGroupManager $userGroupManager
     * @param Logger $logger
     * @param StatusManager $sm
     * @param \Symfony\Component\EventDispatcher\EventDispatcherInterface $eventDispatcher
     * @param \Symfony\Component\Security\Core\Encoder\EncoderFactory $encoderFactory
     *
     * @DI\InjectParams({
     *     "em"                  = @DI\Inject("doctrine.orm.entity_manager"),
     *     "userGroupManager"    = @DI\Inject("user.group.manager"),
     *     "logger"              = @DI\Inject("logger"),
     *     "sm"                  = @DI\Inject("status.manager"),
     *     "eventDispatcher"     = @DI\Inject("event_dispatcher"),
     *     "encoderFactory"      = @DI\Inject("security.encoder_factory")
     * })
     */
    public function __construct(
        EntityManager $em,
        UserGroupManager $userGroupManager,
        Logger $logger,
        StatusManager $sm,
        EventDispatcherInterface $eventDispatcher,
        EncoderFactory $encoderFactory
    )
    {
        $this->em = $em;
        $this->userGroupManager = $userGroupManager;
        $this->logger = $logger;
        $this->sm = $sm;
        $this->eventDispatcher = $eventDispatcher;
        $this->encoderFactory = $encoderFactory;
    }

    /**
     * Get Current user
     *
     * @return MlankaTechAppBundle:User
     */
    public function getCurrentUser()
    {
       if($this->securityTokenStorage->getToken()){
           return $this->securityTokenStorage->getToken()->getUser();
       }
        return false;
    }

    /**
     * Get user by id
     *
     * @param integer $id
     * @return MlankaTechAppBundle:User
     */
    public function getById($id)
    {
        $this->logger->info("Service UserManager getById()");
        return $this->em->getRepository('MlankaTechAppBundle:User')
            ->find($id);
    }

    /**
     * Get user by Slug
     *
     * @param String $slug
     * @return MlankaTechAppBundle:User
     */
    public function getBySlug($slug)
    {
        $this->logger->info("Service UserManager getById()");
        $results = $this->em->getRepository('MlankaTechAppBundle:User')
            ->findBySlug($slug);
        if(is_array($results)){
            return $results[0];
        }
        return false;
    }

    /**
     * Get user by email
     *
     * @param String $email
     * @return MlankaTechAppBundle:User
     */
    public function getByEmail($email)
    {
        $this->logger->info("Service UserManager getByEmail()");
        return $this->em->getRepository('MlankaTechAppBundle:User')
            ->findOneByEmail($email);
    }

    /**
     * Get user by token
     *
     * @param String $token
     * @return MlankaTechAppBundle:User
     */
    public function getByToken($token)
    {
        $this->logger->info("Service  UserManager getByToken()");
        return $this->em->getRepository('MlankaTechAppBundle:User')
            ->findOneByConfirmationToken($token);
    }

    /**
     * Get user by forgotPassword unique string.
     *
     * @param String $forgotPassword
     * @return MlankaTechAppBundle:User
     */
    public function getByforgotPassword($forgotPassword)
    {
        $this->logger->info('Service  UserManager getByforgotPassword()');

        return $this->em->getRepository('MlankaTechAppBundle:User')
            ->findOneByForgotPassword($forgotPassword);
    }

    /**
     * Get query list of all system users
     *
     * @param array $options
     * @return Query
     */
    public function getListAll($options = array())
    {
        $this->logger->info("Service UserManager getListAll()");

        return $this->em->getRepository('MlankaTechAppBundle:User')
            ->getAllQueryList($options);

    }

    /**
     * Get count of all users in the system
     *
     * @return mixed
     */
    public function getCountOfAllUsers()
    {
        $this->logger->info("Service UserManager getCountOfAllUsers()");

        $repo = $this->em->getRepository('MlankaTechAppBundle:User');

        $qb = $repo->createQueryBuilder('u');
        $qb->select('COUNT(u)');
        return $qb->getQuery()->getSingleScalarResult();
    }

    /**
     * Encode password
     *
     * @param User $user
     * @param $plainPassword
     * @return string
     */
    private function encodePassword(User $user, $plainPassword)
    {
        $encoder = $this->encoderFactory->getEncoder($user);
        return $encoder->encodePassword($plainPassword,$user->getSalt());
    }

    /**
     * Create user and trigger send confirmation
     *
     * @param User $user
     */
    public function createUser(\MlankaTech\AppBundle\Entity\User $user)
    {
        $this->logger->info("Service UserManager createUser()");
        //save user
        $password = substr(base_convert(bin2hex(hash('sha256', uniqid(mt_rand(), true), true)), 16, 20), 0, 10);
        $user->setPassword($this->encodePassword($user,$password));
        $user->setTransient($password);
        $user->setGroup($this->userGroupManager->admin());
        $this->create($user);

        $this->eventDispatcher->dispatch(
            UserEvents::NEW_ACCOUNT_CREATED,
            new UserEvent($user)
        );
    }

    /**
     * Create user
     *
     * @param User $user
     * @return User
     */
    public function create(\MlankaTech\AppBundle\Entity\User $user)
    {
        $this->logger->info("Service UserManager create()");

        $user->setStatus($this->sm->active());

        foreach ($user->getGroup()->getRoles() as $role) {
            $user->addUserRole($role);
            if($user->getGroup()->getName() == 'Super Administrator'){
                $user->setAdmin(true);
            }
        }

        if($this->getCurrentUser()){
            $user->setCreatedBy($this->getCurrentUser());
        }else{
            $user->setCreatedBy(NULL);
        }

        $this->em->persist($user);
        $this->em->flush();
        return $user;
    }

    /**
     * Reset password
     *
     * @param User $user
     * @return User
     */
    public function resetPassword(\MlankaTech\AppBundle\Entity\User $user)
    {
        $this->logger->info("Service UserManager resetPassword()");

        $password = $user->getPassword();
        $user->setForgotPassword(null);
        $user->setPassword($this->encodePassword($user,$password));
        $this->em->persist($user);
        $this->em->flush();
        return $user;
    }

    /**
     * Update user
     *
     * @param User $user
     * @return User
     */
    public function update(\MlankaTech\AppBundle\Entity\User $user)
    {
        $this->logger->info("Service UserManager update()");

        $this->em->persist($user);
        $this->em->flush();
        return $user;
    }

    /**
     * Generate forgot password random string and dispatch an event.
     *
     * @param User $user
     * @return User
     */
    public function forgotPassword(\MlankaTech\AppBundle\Entity\User $user)
    {
        $this->logger->info('Service UserManager forgotPassword()');
        $user->setForgotPassword($this->generateRandomString(8));
        $user->setPasswordRequestedAt(new \DateTime());
        $this->em->persist($user);
        $this->em->flush();

        $this->eventDispatcher->dispatch(
            UserEvents::ON_ACCOUNT_FORGOT_PASSWORD,
            new UserEvent($user)
        );

        return $user;
    }

    /**
     * Generate a random string.
     *
     * @param int $length
     * @return string
     */
    public function generateRandomString($length = 10)
    {
        $this->logger->info('Service UserManager generateRandomString()');
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; ++$i) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }

        return $randomString;
    }

    /**
     * Lock user account.
     *
     * @param \MlankaTech\AppBundle\Entity\User $user
     * @return \MlankaTech\AppBundle\Entity\User
     */
    public function suspend(\MlankaTech\AppBundle\Entity\User $user)
    {
        $this->logger->info('Service UserManager lock()');
        $user->setStatus($this->sm->suspended());
        $user->setActive(false);
        $user->setSuspendAt(new \DateTime());
        $user->setSuspendedBy($this->getCurrentUser());
        $user->setLocked(true);
        $this->em->persist($user);
        $this->em->flush();

        return $user;
    }

    /**
     * Activate operator account.
     *
     * @param \MlankaTech\AppBundle\Entity\User $user
     * @return \MlankaTech\AppBundle\Entity\User
     */
    public function activate(\MlankaTech\AppBundle\Entity\User $user)
    {
        $this->logger->info('Service UserManager activate()');
        $user->setStatus($this->sm->active());
        $user->setActive(true);
        $user->setActivatedAt(new \DateTime());
        $user->setActivatedBy($this->getCurrentUser());
        $user->setLocked(false);
        $this->em->persist($user);
        $this->em->flush();

        return $user;
    }

}
