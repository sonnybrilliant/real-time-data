<?php

namespace MlankaTech\AppBundle\Entity\Repository;

use Doctrine\ORM\EntityRepository;
use JMS\DiExtraBundle\Annotation as DI;
use MlankaTech\AppBundle\Services\Core\StatusManager;
use Monolog\Logger;

/**
 * MlankaTech\AppBundle\Repository\UserRepository
 *
 *
 * @author Mfana Ronald Conco <ronald.conco@mlankatech.co.za>
 * @package MlankaTechAppBundle
 * @subpackage Repository
 * @version 0.0.1
 *
 */
class UserRepository extends EntityRepository
{

    /**
     * Status Manager
     * @var object
     */
    protected $statusManager;

    /**
     * @var Monolog logger
     */
    protected $logger;

    /**
     * @DI\InjectParams({
     *     "statusManager" = @DI\Inject("status.manager"),
     * })
     */
    public function setStatusManager(StatusManager $statusManager)
    {
        $this->statusManager = $statusManager;
    }

    /**
     * @DI\InjectParams({
     *     "logger"   = @DI\Inject("logger"),
     * })
     */
    public function setLogger(Logger $logger)
    {
        $this->logger = $logger;
    }

    /**
     * Get query of all system users
     *
     * @param array $options
     * @return Query
     */
    public function getAllQueryList($options)
    {

        $defaultOptions = array(
            'search' => '',
            'filterBy' => '',
            'sort' => 'u.id',
            'direction' => 'desc',
            'show' => 10,
        );

        foreach ($options as $key => $values) {
            if (!$values) {
                $options[$key] = $defaultOptions[$key];
            }
        }

        $qb = $this->createQueryBuilder('u')->select('u')
            ->innerJoin('u.status','s')
            ->innerJoin('u.group','g');



        if ((isset($options['filterBy'])) && ($options['filterBy'] == '')) {
            $qb->andWhere('u.deleted =:status')
                ->setParameter('status', false);
        }else{
            if($options['filterBy'] == 'Active'){
                $qb->andWhere('u.status =:status')
                    ->setParameter('status',$this->statusManager->active());
            }

            if($options['filterBy'] == 'Locked'){
                $qb->andWhere('u.status =:status_locked')
                    ->orWhere('u.status =:status_expired')
                    ->setParameters(array(
                        'status_locked' => $this->statusManager->locked(),
                        'status_expired' => $this->statusManager->expired()
                    ));


            }
        }

        // search
        if ($options['search']) {
            if ($options['search'] != "") {
                $qb->andWhere($qb->expr()->orx(
                    $qb->expr()->like('u.firstName', $qb->expr()->literal('%' . $options['search'] . '%')),
                    $qb->expr()->like('u.lastName', $qb->expr()->literal('%' . $options['search'] . '%')),
                    $qb->expr()->like('u.email', $qb->expr()->literal('%' . $options['search'] . '%'))
                ));
            }
        }

        $qb->orderBy($options['sort'], $options['direction']);
        return $qb->getQuery();
    }

    /**
     * Get all active users
     *
     * @return void
     */
    public function getAllActive()
    {

        $qb = $this->createQueryBuilder('u')->select('u')
            ->andWhere('u.isDeleted =:is_deleted')
            ->andWhere('u.status =:status')
            ->setParameters(array(
                'is_deleted' => false,
                'status' => $this->sm->active()
            ));
        $qb->orderBy('u.company', 'DESC');
        return $qb->getQuery()->getResult();
    }
}