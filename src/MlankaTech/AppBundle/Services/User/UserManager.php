<?php

namespace MlankaTech\AppBundle\Services\User;

use Doctrine\ORM\EntityManager;
use MlankaTech\AppBundle\Entity\User;
use JMS\DiExtraBundle\Annotation as DI;
use JMS\DiExtraBundle\Annotation\Inject;
use MlankaTech\AppBundle\Services\Core\StatusManager;
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
     * Security Context
     * @var object
     * @Inject("security.context", required = false)
     */
    public $securityContext;

    /**
     *
     * Class construct
     *
     * @param EntityManager $em
     * @param Logger $logger
     * @param StatusManager $sm
     * @param \Symfony\Component\EventDispatcher\EventDispatcherInterface $eventDispatcher
     *
     * @DI\InjectParams({
     *     "em"                  = @DI\Inject("doctrine.orm.entity_manager"),
     *     "logger"              = @DI\Inject("logger"),
     *     "sm"                  = @DI\Inject("status.manager")
     * })
     */
    public function __construct(
        EntityManager $em,
        Logger $logger,
        StatusManager $sm
    )
    {
        $this->em = $em;
        $this->logger = $logger;
        $this->sm = $sm;
    }

    /**
     * Get Current user
     *
     * @return MlankaTechAppBundle:User
     */
    public function getCurrentUser()
    {
        if($this->securityContext->getToken()){
            return $this->securityContext->getToken()->getUser();
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
     * Create user and trigger send confirmation
     *
     * @param User $user
     */
    public function createUser(\MlankaTech\AppBundle\Entity\User $user)
    {
        $this->logger->info("Service UserManager createUser()");
        //save user
        $this->create($user);
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

}
