<?php
/**
 * Created by IntelliJ IDEA.
 * User: alberto
 * Date: 27/12/18
 * Time: 04:47 PM
 */

namespace App\Data\Transformers;

use DbModels\Entities\InventoryEvidence;
use League\Fractal\TransformerAbstract;

/**
 * Class InventoryEvidenceEntityTransformer
 * @package App\Data\Transformers
 */
class InventoryEvidenceEntityTransformer extends TransformerAbstract
{
    protected $availableIncludes = [
        'store',
        'brand',
        'furnitureType',
        'clerk',
        'user',
    ];

    /**
     * @param InventoryEvidence $item
     * @return array
     */
    public function transform(InventoryEvidence $item)
    {
        return [
            'id' => (int)$item->getId(),
            'code' => $item->getCode(),
            'comments' => $item->getComments(),
            'storeId' => (int)$item->getStore()->getId(),
            'brandId' => (int)$item->getBrand()->getId(),
            'furnitureTypeId' => (int)$item->getFurnitureType()->getId(),
            'clerkId' => (int)$item->getClerk()->getId(),
            'userId' => (int)$item->getUser()->getId(),
            'regStatus' => (int)$item->getRegStatus(),
        ];
    }

    /**
     * @param InventoryEvidence $item
     * @return \League\Fractal\Resource\Item
     */
    public function includeStore(InventoryEvidence $item)
    {
        return $this->item($item->getStore(), new StoreEntityTransformer);
    }

    /**
     * @param InventoryEvidence $item
     * @return \League\Fractal\Resource\Item
     */
    public function includeBrand(InventoryEvidence $item)
    {
        return $this->item($item->getBrand(), new BrandEntityTransformer);
    }

    /**
     * @param InventoryEvidence $item
     * @return \League\Fractal\Resource\Item
     */
    public function includeFurnitureType(InventoryEvidence $item)
    {
        return $this->item($item->getFurnitureType(), new FurnitureTypeEntityTransformer);
    }

    /**
     * @param InventoryEvidence $item
     * @return \League\Fractal\Resource\Item
     */
    public function includeClerk(InventoryEvidence $item)
    {
        return $this->item($item->getClerk(), new ClerkEntityTransformer);
    }

    /**
     * @param InventoryEvidence $item
     * @return \League\Fractal\Resource\Item
     */
    public function includeUser(InventoryEvidence $item)
    {
        return $this->item($item->getUser(), new UserEntityTransformer);
    }
}