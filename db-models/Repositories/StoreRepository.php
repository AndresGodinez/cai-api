<?php
/**
 * Created by IntelliJ IDEA.
 * User: alberto
 * Date: 20/12/18
 * Time: 10:52 AM
 */

namespace DbModels\Repositories;

use DbModels\Consts\DefaultEntityRegStatus;
use DbModels\Entities\ChainStore;
use DbModels\Entities\InventoryEvidence;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Query\Expr;


/**
 * Class StoreRepository
 * @package DbModels\Repositories
 */
class StoreRepository extends EntityRepository
{
    public function getPendingStores()
    {
        $qb = $this->createQueryBuilder('s');
        $qb->select(
            's.id as storeId',
            's.name as storeName',
            's.cityName as storeCityName',
            's.postalCode as storePostalCode',
            's.type as storeType',
            's.address as storeAddress',
            'cs.name as ChainStoreName'

        );
        $qb->leftJoin(InventoryEvidence::class, 'ie', Expr\Join::WITH, 'ie.store = s.id');
        $qb->leftJoin(ChainStore::class, 'cs', Expr\Join::WITH, 's.chainStore = cs.id');

        $qb->andWhere($qb->expr()->eq('s.regStatus', DefaultEntityRegStatus::ACTIVE));
        $qb->andWhere("ie.id IS NULL");

        return $qb->getQuery()->getArrayResult();
    }
}
