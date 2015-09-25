<?php

namespace MlankaTech\AppBundle\Entity\Repository;

use Doctrine\ORM\EntityRepository;

/**
 * MlankaTech\AppBundle\Repository\TrainTypeRepository
 *
 *
 * @author Mfana Ronald Conco <ronald.conco@mlankatech.co.za>
 * @package MlankaTechAppBundle
 * @subpackage Repository
 * @version 0.0.1
 *
 */
class TrainTypeRepository extends EntityRepository
{
    /**
     * Get query of all train types
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

        $qb = $this->createQueryBuilder('t')->select('t');

        // search
        if ($options['search']) {
            if ($options['search'] != "") {
                $qb->andWhere($qb->expr()->orx(
                    $qb->expr()->like('t.type', $qb->expr()->literal('%' . $options['search'] . '%'))
                ));
            }
        }

        $qb->orderBy($options['sort'], $options['direction']);
        return $qb->getQuery();
    }
}
