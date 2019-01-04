<?php
/**
 * Created by IntelliJ IDEA.
 * User: alberto
 * Date: 20/12/18
 * Time: 10:19 AM
 */

namespace DbModels\Repositories;

use App\Exceptions\InternalException;
use DbModels\Entities\State;
use DbModels\Entities\Store;
use DbModels\Entities\StoreClerk;
use DbModels\Entities\User;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Query\Expr;

/**
 * Class UserRepository
 * @package DbModels\Repositories
 */
class UserRepository extends EntityRepository
{
    /**
     * @param User $user
     * @return mixed
     * @throws InternalException
     */
    public function getStatesDataFromUser(User $user)
    {
        $clerk = $user->getClerk();

        if (!$clerk) {
            throw new InternalException("Invalid user. The user is not related to a clerk.");
        }

        $qb = $this->getEntityManager()->createQueryBuilder();
        $qb->select('c.id AS stateId', 'c.name AS stateName', 'c.code AS stateCode', 'b.id AS storeId', 'b.name AS storeName', 'b.address AS storeAddress');
        $qb->from(StoreClerk::class, 'a');
        $qb->leftJoin(Store::class, 'b', Expr\Join::WITH, 'a.store = b.id');
        $qb->leftJoin(State::class, 'c', Expr\Join::WITH, 'b.state = c.id');
        $qb->where('a.clerk = :clerkId');
        $qb->orderBy('b.id');

        $qb->setParameter('clerkId', $clerk->getId());

        $q = $qb->getQuery();

        return $q->getResult();
    }
}