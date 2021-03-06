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
            's.sapCode as storeSapCode',
            's.postalCode as storePostalCode',
            's.type as storeType',
            's.address as storeAddress',
            'cs.name as ChainStoreName',
            'ie.id as inventoryId'
        );
        $qb->leftJoin(InventoryEvidence::class, 'ie', Expr\Join::WITH, 'ie.store = s.id');
        $qb->leftJoin(ChainStore::class, 'cs', Expr\Join::WITH, 's.chainStore = cs.id');

        $qb->where("ie.id IS NULL");
        $qb->andWhere($qb->expr()->eq('s.regStatus', DefaultEntityRegStatus::ACTIVE));


        return $qb->getQuery()->getArrayResult();
    }

    public function getQuantityStores()
    {
        $qb = $this->createQueryBuilder('s');
        $qb->select('count(s.id) as quantity');
        $qb ->where($qb->expr()->eq('s.regStatus', DefaultEntityRegStatus::ACTIVE));

        return $qb->getQuery()->getArrayResult();
    }

    public function storesWithoutRegister()
    {
        $qb = $this->createQueryBuilder('s');
        $qb->select('count(DISTINCT s.id) as quantity', 'ie.id as inventoryId');

        $qb->leftJoin(InventoryEvidence::class, 'ie', Expr\Join::WITH, 's.id = ie.store');
        $qb->where("ie.id IS NULL");
        $qb->andWhere($qb->expr()->eq('s.regStatus', DefaultEntityRegStatus::ACTIVE));

        $result = $qb->getQuery()->getArrayResult();
        return $result[0]['quantity'];
    }

    public function storesWithAtLeastOneRecord()
    {
        $qb = $this->createQueryBuilder('s');
        $qb->select('count(DISTINCT s.id) as quantity', 'ie.id as inventoryId');

        $qb->leftJoin(InventoryEvidence::class, 'ie', Expr\Join::WITH, 's.id = ie.store');
        $qb->where("ie.id IS NOT NULL");
        $qb->andWhere($qb->expr()->eq('s.regStatus', DefaultEntityRegStatus::ACTIVE));

        $result = $qb->getQuery()->getArrayResult();

        return $result[0]['quantity'];
    }
}
