<?php
/**
 * Created by IntelliJ IDEA.
 * User: alberto
 * Date: 27/12/18
 * Time: 05:01 PM
 */

namespace App\Data\Transformers;

use DbModels\Entities\User;
use League\Fractal\TransformerAbstract;

/**
 * Class UserEntityTransformer
 * @package App\Data\Transformers
 */
class UserEntityTransformer extends TransformerAbstract
{
    /**
     * @param User $item
     * @return array
     */
    public function transform(User $item)
    {
        $clerkId = !!$item->getClerk() ? $item->getClerk()->getId() : 0;

        return [
            'id' => $item->getId(),
            'name' => $item->getName(),
            'username' => $item->getUsername(),
            'type' => (int)$item->getType(),
            'clerkId' => (int)$clerkId,
            'regStatus' => $item->getId(),
        ];
    }
}