<?php
/**
 * Created by IntelliJ IDEA.
 * User: alberto
 * Date: 20/12/18
 * Time: 10:07 AM
 */

namespace DbModels\Repositories;

use App\Data\Models\ClerkCaptureStatisticData;
use App\Exceptions\InternalException;
use DbModels\Entities\ChainStore;
use DbModels\Entities\Clerk;
use DbModels\Entities\InventoryEvidence;
use DbModels\Entities\State;
use DbModels\Entities\Store;
use DbModels\Entities\StoreClerk;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Query\Expr;

/**
 * Class ClerkRepository
 * @package DbModels\Repositories
 */
class ClerkRepository extends EntityRepository
{
    /**
     * @param int $clerkId
     * @return mixed
     * @throws InternalException
     */
    public function getCaptureStatisticsData(int $clerkId)
    {
        /** @var Clerk $clerk */
        $clerk = $this->find($clerkId);

        if (!$clerkId) {
            throw new InternalException("Invalid clerk. The register doesnt exists.");
        }

        $qb = $this->getEntityManager()->createQueryBuilder();
        $qb->select('st.id AS stateId', 'st.name AS stateName', 'st.code AS stateCode');
        $qb->addSelect('s.id AS storeId', 's.name AS storeName', 's.address AS storeAddress');
        $qb->addSelect('cs.name AS chainStoreName');
        $qb->addSelect('COUNT(ie.id) AS capturedQuant');

        $qb->from(StoreClerk::class, 'sc');
        $qb->leftJoin(Store::class, 's', Expr\Join::WITH, 'sc.store = s.id');
        $qb->leftJoin(ChainStore::class, 'cs', Expr\Join::WITH, 's.chainStore = cs.id');
        $qb->leftJoin(State::class, 'st', Expr\Join::WITH, 's.state = st.id');
        $qb->leftJoin(InventoryEvidence::class, 'ie', Expr\Join::WITH, "ie.store = sc.store AND ie.clerk = sc.clerk");

        $qb->where('sc.clerk = :clerkId');
        $qb->orderBy('st.id');
        $qb->groupBy('s');

        $qb->setParameter('clerkId', $clerk->getId());

        $q = $qb->getQuery();

        $result = $q->getResult();

        $data = new ClerkCaptureStatisticData($clerk, $result);

        return $data;
    }
}