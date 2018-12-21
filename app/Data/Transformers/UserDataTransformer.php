<?php
/**
 * Created by IntelliJ IDEA.
 * User: alberto
 * Date: 21/12/18
 * Time: 04:55 PM
 */

namespace App\Data\Transformers;

use App\Data\Models\UserData;
use League\Fractal\TransformerAbstract;

/**
 * Class UserDataTransformer
 * @package App\Data\Transformers
 */
class UserDataTransformer extends TransformerAbstract
{
    /**
     * @param UserData $item
     * @return array
     */
    public function transform(UserData $item)
    {
        $user = $item->getUser();
        $states = $item->getStatesData();

        return [
            'id' => $user->getId(),
            'name' => $user->getName(),
            'states' => $states,
        ];
    }
}