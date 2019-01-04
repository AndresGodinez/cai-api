<?php
/**
 * Created by IntelliJ IDEA.
 * User: alberto
 * Date: 20/12/18
 * Time: 01:04 PM
 */

namespace DbModels\Repositories;

use DbModels\Entities\Clerk;
use DbModels\Entities\InventoryEvidence;
use DbModels\Entities\StoreClerk;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Query\Expr;

/**
 * Class StoreClerkRepository
 * @package DbModels\Repositories
 */
class StoreClerkRepository extends EntityRepository
{
    /**
     * @return mixed
     */
    public function getProgressPercByClerkData()
    {
        $qb = $this->getEntityManager()->createQueryBuilder();

        $qb->select('sc', 's AS store', 'c.id AS clerkId', 'c.name AS clerkName');
        $qb->addSelect('COUNT(DISTINCT sc) AS assignedStoreNumber');
        $qb->addSelect('COUNT(DISTINCT ie) AS capturedStore');

        $qb->from(StoreClerk::class, 'sc');
        $qb->join('sc.store', 's');
        $qb->join(Clerk::class, 'c', Expr\Join::WITH, 'sc.clerk = c.id');
        $qb->leftJoin(InventoryEvidence::class, 'ie', Expr\Join::WITH, 'sc.clerk = ie.clerk');

        $qb->groupBy('sc.clerk');

        $q = $qb->getQuery();

        $data = $q->getResult();

        return $data;
    }
}