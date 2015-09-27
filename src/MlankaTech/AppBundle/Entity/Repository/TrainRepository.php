<?php

namespace MlankaTech\AppBundle\Entity\Repository;

use Doctrine\ORM\EntityRepository;

/**
 * TrainRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class TrainRepository extends EntityRepository
{
    /**
     * Get query of all trains
     *
     * @param array $options
     * @return Query
     */
    public function getAllQueryList($options)
    {

        $defaultOptions = array(
            'search' => '',
            'filterBy' => '',
            'sort' => 't.id',
            'direction' => 'desc',
            'show' => 10,
        );

        foreach ($options as $key => $values) {
            if (!$values) {
                $options[$key] = $defaultOptions[$key];
            }
        }

        $qb = $this->createQueryBuilder('t')->select('t')
            ->innerJoin('t.status','s')
            ->innerJoin('t.condition','c');

        // search
        if ($options['search']) {
            if ($options['search'] != "") {
                $qb->andWhere($qb->expr()->orx(
                    $qb->expr()->like('t.unit', $qb->expr()->literal('%' . $options['search'] . '%'))
                ));
            }
        }

        $qb->orderBy($options['sort'], $options['direction']);
        return $qb->getQuery();
    }
}