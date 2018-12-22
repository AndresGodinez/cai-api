<?php
/**
 * Created by IntelliJ IDEA.
 * User: alberto
 * Date: 22/12/18
 * Time: 11:38 AM
 */

namespace App\Data\Transformers;

use DbModels\Entities\FurnitureType;
use League\Fractal\TransformerAbstract;

/**
 * Class FurnitureTypeListTransformer
 * @package App\Data\Transformers
 */
class FurnitureTypeListTransformer extends TransformerAbstract
{
    /**
     * @param FurnitureType $item
     * @return array
     */
    public function transform(FurnitureType $item)
    {
        $label = $item->getName();

        return [
            'value' => (int)$item->getId(),
            'label' => $label,
        ];
    }
}