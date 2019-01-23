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
use DbModels\Entities\State;
use DbModels\Entities\StoreClerk;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Query\Expr;
use function PHPSTORM_META\elementType;

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

    public function getProgressPercByStateData()
    {
        $qb = $this->getEntityManager()->createQueryBuilder();

        $qb->select('sc', 's AS store', 's.id AS storeId', 's.name AS storeName', 'sta.id as stateId', 'sta.name as stateName');
        $qb->addSelect('COUNT(DISTINCT sc) AS assignedStoreNumber');
        $qb->addSelect('COUNT(DISTINCT ie) AS capturedStore');

        $qb->from(StoreClerk::class, 'sc');
        $qb->join('sc.store', 's');
        $qb->join('s.state', 'st');
        $qb->join(State::class, 'sta', Expr\Join::WITH, 's.state = sta.id');
        $qb->leftJoin(InventoryEvidence::class, 'ie', Expr\Join::WITH, 'sc.store
        = ie.store');

        $qb->groupBy('sta.id');

        $q = $qb->getQuery();

        return $q->getArrayResult();
    }


}