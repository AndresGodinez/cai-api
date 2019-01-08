<?php
/**
 * Created by IntelliJ IDEA.
 * User: alberto
 * Date: 20/12/18
 * Time: 01:07 PM
 */

namespace DbModels\Repositories;

use DbModels\Consts\DefaultEntityRegStatus;
use Doctrine\ORM\EntityRepository;

/**
 * Class InventoryEvidenceRepository
 * @package DbModels\Repositories
 */
class InventoryEvidenceRepository extends EntityRepository
{
    /**
     * @param int $results
     * @param int $page
     * @param int $userId
     * @return array
     */
    public function getValidRegistersFromUserId(int $results, int $page, int $userId)
    {
        $qb = $this->createQueryBuilder('ie');
        $qb->where($qb->expr()->eq('ie.user', $userId));
        $qb->where($qb->expr()->eq('ie.regStatus', DefaultEntityRegStatus::ACTIVE));

        $firstResult = $results * $page;

        $qb->setMaxResults($results);
        $qb->setFirstResult($firstResult);

        return $qb->getQuery()->getResult();
    }

    /**
     * @param int $userId
     * @return array
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function getValidRegistersCountFromUserId(int $userId)
    {
        $qb = $this->createQueryBuilder('ie');
        $qb->select('COUNT(ie.id)');
        $qb->where($qb->expr()->eq('ie.user', $userId));
        $qb->where($qb->expr()->eq('ie.regStatus', DefaultEntityRegStatus::ACTIVE));

        return $qb->getQuery()->getSingleScalarResult();
    }
}