<?php
/**
 * Created by IntelliJ IDEA.
 * User: alberto
 * Date: 20/12/18
 * Time: 01:07 PM
 */

namespace DbModels\Repositories;

use DbModels\Consts\DefaultEntityRegStatus;
use DbModels\Entities\Brand;
use DbModels\Entities\ChainStore;
use DbModels\Entities\Clerk;
use DbModels\Entities\FurnitureType;
use DbModels\Entities\State;
use DbModels\Entities\Store;
use DbModels\Entities\User;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Query\Expr;

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
        $qb->andWhere($qb->expr()->eq('ie.regStatus', DefaultEntityRegStatus::ACTIVE));

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
        $qb->andWhere($qb->expr()->eq('ie.regStatus', DefaultEntityRegStatus::ACTIVE));

        return $qb->getQuery()->getSingleScalarResult();
    }


    /**
     * @param $params
     * @return array
     */
    public function getAllReports($params)
    {
        if (isset($params['startDate'])){
            $startDate = $params['startDate'];
        }
        if (isset($params['endDate'])){
            $endDate = $params['endDate'];
        }

        if (isset($startDate) && isset($endDate)){
            $qb = $this->createQueryBuilder('ie');
            $qb->select(
                'ie',
                'ie.id as inventoryId',
                'ie.code as inventoryCode',
                'ie.regCreatedDt as captureDate',
                'ie.comments as inventoryComment',
                's.id as storeId',
                's.name as storeName',
                's.address as storeAddress',
                's.type as storeType',
                's.cityName as cityName',
                's.postalCode as storePostalCode',
                'b.name as brandName',
                'ft.name as furniture_name',
                'c.code as clerkCode',
                'cs.name as chainStore',
                'c.name as clerk_name', 'u.name'
            );
            $qb->leftJoin(Store::class, 's', Expr\Join::WITH, 's.id = ie.store');
            $qb->leftJoin(Brand::class, 'b', Expr\Join::WITH, 'b.id = ie.brand');
            $qb->leftJoin(FurnitureType::class, 'ft', Expr\Join::WITH, 'ft.id = ie.furnitureType');
            $qb->leftJoin(Clerk::class, 'c', Expr\Join::WITH, 'c.id = ie.clerk');
            $qb->leftJoin(ChainStore::class, 'cs', Expr\Join::WITH, 'cs.id = s.chainStore');
            $qb->leftJoin(User::class, 'u', Expr\Join::WITH, 'u.id = ie.user');
            $qb->andWhere($qb->expr()->eq('ie.regStatus', DefaultEntityRegStatus::ACTIVE));
            $qb->andWhere("ie.regCreatedDt BETWEEN $startDate AND $endDate");

            return $qb->getQuery()->getArrayResult();
        }else{
            $qb = $this->createQueryBuilder('ie');
            $qb->select(
                'ie',
                'ie.id as inventoryId',
                'ie.code as inventoryCode',
                'ie.regCreatedDt as captureDate',
                'ie.comments as inventoryComment',
                's.id as storeId',
                's.name as storeName',
                's.address as storeAddress',
                's.type as storeType',
                's.cityName as cityName',
                's.postalCode as storePostalCode',
                'b.name as brandName',
                'ft.name as furniture_name',
                'c.code as clerkCode',
                'cs.name as chainStore',
                'c.name as clerk_name', 'u.name'
            );
            $qb->leftJoin(Store::class, 's', Expr\Join::WITH, 's.id = ie.store');
            $qb->leftJoin(Brand::class, 'b', Expr\Join::WITH, 'b.id = ie.brand');
            $qb->leftJoin(FurnitureType::class, 'ft', Expr\Join::WITH, 'ft.id = ie.furnitureType');
            $qb->leftJoin(Clerk::class, 'c', Expr\Join::WITH, 'c.id = ie.clerk');
            $qb->leftJoin(ChainStore::class, 'cs', Expr\Join::WITH, 'cs.id = s.chainStore');
            $qb->leftJoin(User::class, 'u', Expr\Join::WITH, 'u.id = ie.user');
            $qb->andWhere($qb->expr()->eq('ie.regStatus', DefaultEntityRegStatus::ACTIVE));

            return $qb->getQuery()->getArrayResult();
        }
    }

    public function getProgressState()
    {
        $qb = $this->createQueryBuilder('ie');
        $qb->select(
            'ie.id as inventoryId',
            's.name as StoreName',
            's.id as storeId',
            'st.id as stateId',
            'st.name as stateName'
        );
        $qb->leftJoin(Store::class, 's', Expr\Join::WITH, 's.id = ie.store');
        $qb->leftJoin(State::class, 'st', Expr\Join::WITH, 'st.id = s.state');
        $qb->andWhere($qb->expr()->eq('ie.regStatus', DefaultEntityRegStatus::ACTIVE));

        return $qb->getQuery()->getArrayResult();
    }

    public function getProgressByBrand()
    {
        $qb = $this->createQueryBuilder('ie');
        $qb->select(
            'ie.id as inventoryId',
            'b.id as brandId',
            'b.name as brandName',
            's.id as storeId',
            's.name as storeName'
        );
        $qb->leftJoin(Brand::class, 'b', Expr\Join::WITH, 'b.id = ie.brand');
        $qb->leftJoin(Store::class, 's', Expr\Join::WITH, 's.id = ie.store');
        $qb->andWhere($qb->expr()->eq('ie.regStatus', DefaultEntityRegStatus::ACTIVE));

        return $qb->getQuery()->getArrayResult();
    }
}
