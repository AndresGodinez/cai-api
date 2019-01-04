<?php
/**
 * Created by IntelliJ IDEA.
 * User: alberto
 * Date: 4/01/19
 * Time: 10:55 AM
 */

namespace App\Data\Transformers;

use DbModels\Entities\StoreClerk;
use League\Fractal\TransformerAbstract;

/**
 * Class ProgressPercByClerkDataTransformer
 * @package App\Data\Transformers
 */
class ProgressPercByClerkDataTransformer extends TransformerAbstract
{
    /**
     * @param array $item
     * @return array
     */
    public function transform(array $item)
    {
        /** @var StoreClerk $sc */
        $sc = $item[0];

        return [
            'id' => (int)$sc->getId(),
            'store_id' => (int)$sc->getStore()->getId(),
            'clerk_id' => (int)$item['clerkId'],
            'name' => $item['clerkName'],
            'assigned_store_number' => (int)$item['assignedStoreNumber'],
            'captured_store' => (int)$item['capturedStore'],
        ];
    }
}