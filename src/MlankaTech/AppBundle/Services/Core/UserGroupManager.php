<?php

namespace MlankaTech\AppBundle\Services\Core;

use Doctrine\ORM\EntityManager;
use Monolog\Logger;
use JMS\DiExtraBundle\Annotation as DI;

/**
 * MlankaTech\AppBundle\Services\Core\UserGroupManager.
 *
 * @DI\Service("user.group.manager")
 *
 * @author Mfana Ronald Conco <ronald.conco@mlankatech.co.za>
 *
 * @version 0.0.1
 */
class UserGroupManager
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
     * Class construct.
     *
     * @param EntityManager $em
     * @param Logger        $logger
     *
     *
     * @DI\InjectParams({
     *     "em"          = @DI\Inject("doctrine.orm.entity_manager"),
     *     "logger"      = @DI\Inject("logger"),
     * })
     */
    public function __construct(EntityManager $em, Logger $logger)
    {
        $this->em = $em;
        $this->logger = $logger;

        return $this;
    }

    /**
     * Get user group by name.
     *
     * @param String $type
     *
     * @return MlankaTechAppBundle:OrganisationType
     *
     * @throws \Exception
     */
    public function getByName($type)
    {
        $this->logger->info('UserGroupManager getByName()');

        $userGroup = $this->em
            ->getRepository('MlankaTechAppBundle:UserGroup')
            ->getType($type);

        if (!$userGroup) {
            $this->logger->error('UserGroupManager getByName()'.$type.' User group');
            throw new \Exception('Exception, no '.$type.' user group found');
        }

        return $userGroup;
    }

    /**
     * get admin user group.
     *
     * @return MlankaTechAppBundle:UserGroup
     */
    public function admin()
    {
        $this->logger->info('UserGroupManager admin()');

        return $this->getByName('Super administrator');
    }
}
