<?php
/**
 * Created by IntelliJ IDEA.
 * User: alberto
 * Date: 20/12/18
 * Time: 10:45 AM
 */

namespace DbModels\Repositories;

use App\Exceptions\InternalException;
use DbModels\Consts\DefaultEntityRegStatus;
use DbModels\Entities\Brand;
use DbModels\Entities\BrandFurnitureType;
use DbModels\Entities\FurnitureType;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Query\Expr;

/**
 * Class BrandRepository
 * @package DbModels\Repositories
 */
class BrandRepository extends EntityRepository
{
    /**
     * @return array
     */
    public function getValidRegisters()
    {
        return $this->findBy(['regStatus' => DefaultEntityRegStatus::ACTIVE]);
    }

    /**
     * @param int $brandId
     * @return mixed
     * @throws InternalException
     */
    public function getFurnitureTypesFromBrand(int $brandId)
    {
        /** @var Brand $brand */
        $brand = $this->find($brandId);

        if (!$brand) {
            throw new InternalException("The brand register doesnt exist.");
        }

        $qb = $this->getEntityManager()->createQueryBuilder();

        $qb->select('ft');
        $qb->from(BrandFurnitureType::class, 'bft');
        $qb->leftJoin(FurnitureType::class, 'ft', Expr\Join::WITH, 'bft.furnitureType = ft.id');
        $qb->where($qb->expr()->eq('bft.brand', $brand->getId()));
        $qb->andWhere($qb->expr()->eq('ft.regStatus', DefaultEntityRegStatus::ACTIVE));
        $qb->orderBy('ft.name');

        $q = $qb->getQuery();

        return $q->getResult();
    }
}