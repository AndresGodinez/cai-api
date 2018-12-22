<?php
/**
 * Created by IntelliJ IDEA.
 * User: alberto
 * Date: 22/12/18
 * Time: 11:22 AM
 */

namespace App\Data\Transformers;

use DbModels\Entities\Brand;
use League\Fractal\TransformerAbstract;

/**
 * Class BrandListTransformer
 * @package App\Data\Transformers
 */
class BrandListTransformer extends TransformerAbstract
{
    /**
     * @param Brand $item
     * @return array
     */
    public function transform(Brand $item)
    {
        $label = $item->getName();

        return [
            'value' => (int)$item->getId(),
            'label' => $label,
        ];
    }
}