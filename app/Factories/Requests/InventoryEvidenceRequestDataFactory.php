<?php
/**
 * Created by IntelliJ IDEA.
 * User: alberto
 * Date: 27/12/18
 * Time: 11:27 AM
 */

namespace App\Factories\Requests;

use App\Data\Requests\InventoryEvidenceCreateRequestData;
use Doctrine\ORM\EntityManagerInterface;

/**
 * Class InventoryEvidenceRequestDataFactory
 * @package App\Factories\Requests
 */
class InventoryEvidenceRequestDataFactory
{
    /**
     * @param EntityManagerInterface $em
     * @param array $args
     * @return InventoryEvidenceCreateRequestData
     */
    public static function buildInventoryEvidenceCreateRegisterRequestData(EntityManagerInterface $em, array $args)
    {
        $inst = new InventoryEvidenceCreateRequestData();

        $inst->setEm($em);
        $inst->setCode($args['code']);
        $inst->setComments($args['comments']);
        $inst->setStoreId((int)$args['storeId']);
        $inst->setBrandId((int)$args['brandId']);
        $inst->setFurnitureTypeId((int)$args['furnitureTypeId']);
        $inst->setClerkId((int)$args['clerkId']);

        return $inst;
    }
}