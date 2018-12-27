<?php
/**
 * Created by IntelliJ IDEA.
 * User: alberto
 * Date: 27/12/18
 * Time: 05:00 PM
 */

namespace App\Data\Transformers;

use DbModels\Entities\Clerk;
use League\Fractal\TransformerAbstract;

/**
 * Class ClerkEntityTransformer
 * @package App\Data\Transformers
 */
class ClerkEntityTransformer extends TransformerAbstract
{
    /**
     * @param Clerk $item
     * @return array
     */
    public function transform(Clerk $item)
    {
        return [
            'id' => (int)$item->getId(),
            'name' => $item->getName(),
            'code' => $item->getCode(),
            'regStatus' => (int)$item->getRegStatus(),
        ];
    }
}