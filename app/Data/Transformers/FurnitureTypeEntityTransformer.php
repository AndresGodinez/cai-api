<?php
/**
 * Created by IntelliJ IDEA.
 * User: alberto
 * Date: 27/12/18
 * Time: 04:59 PM
 */

namespace App\Data\Transformers;

use DbModels\Entities\FurnitureType;
use League\Fractal\TransformerAbstract;

/**
 * Class FurnitureTypeEntityTransformer
 * @package App\Data\Transformers
 */
class FurnitureTypeEntityTransformer extends TransformerAbstract
{
    /**
     * @param FurnitureType $item
     * @return array
     */
    public function transform(FurnitureType $item)
    {
        return [
            'id' => (int)$item->getId(),
            'name' => $item->getName(),
            'description' => $item->getDescription(),
            'regStatus' => (int)$item->getRegStatus(),
        ];
    }
}