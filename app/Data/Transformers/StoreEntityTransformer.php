<?php
/**
 * Created by IntelliJ IDEA.
 * User: alberto
 * Date: 27/12/18
 * Time: 04:56 PM
 */

namespace App\Data\Transformers;

use DbModels\Entities\Store;
use League\Fractal\TransformerAbstract;

/**
 * Class StoreEntityTransformer
 * @package App\Data\Transformers
 */
class StoreEntityTransformer extends TransformerAbstract
{
    /**
     * @param Store $item
     * @return array
     */
    public function transform(Store $item)
    {
        return [
            'id' => (int)$item->getId(),
            'name' => $item->getName(),
            'cityName' => $item->getCityName(),
            'address' => $item->getAddress(),
            'postalCode' => $item->getPostalCode(),
            'schedule' => $item->getSchedule(),
            'type' => $item->getType(),
            'stateId' => (int)$item->getState()->getId(),
            'chainStoreId' => (int)$item->getChainStore()->getId(),
            'regStatus' => (int)$item->getRegStatus(),
        ];
    }
}