<?php
/**
 * Created by IntelliJ IDEA.
 * User: alberto
 * Date: 22/12/18
 * Time: 11:18 AM
 */

namespace App\Data\Transformers;

use DbModels\Entities\Line;
use League\Fractal\TransformerAbstract;

/**
 * Class LineEntityTransformer
 * @package App\Data\Transformers
 */
class LineEntityTransformer extends TransformerAbstract
{
    /**
     * @param Line $item
     * @return array
     */
    public function transform(Line $item)
    {
        return [
            'id' => (int)$item->getId(),
            'name' => $item->getName(),
            'code' => $item->getCode(),
            'regStatus' => (int)$item->getRegStatus(),
        ];
    }
}