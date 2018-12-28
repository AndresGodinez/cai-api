<?php
/**
 * Created by IntelliJ IDEA.
 * User: alberto
 * Date: 27/12/18
 * Time: 06:32 PM
 */

namespace App\Data\Transformers;

use DbModels\Entities\InventoryEvidencePhoto;
use League\Fractal\TransformerAbstract;

/**
 * Class InventoryEvidencePhotoEntityTransformer
 * @package App\Data\Transformers
 */
class InventoryEvidencePhotoEntityTransformer extends TransformerAbstract
{
    /**
     * @param InventoryEvidencePhoto $item
     * @return array
     */
    public function transform(InventoryEvidencePhoto $item)
    {
        return [
            'id' => $item->getId(),
            'filePath' => $item->getFilePath(),
            'type' => (int)$item->getType(),
        ];
    }
}