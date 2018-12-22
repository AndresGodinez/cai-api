<?php
/**
 * Created by IntelliJ IDEA.
 * User: alberto
 * Date: 22/12/18
 * Time: 11:17 AM
 */

namespace App\Data\Transformers;

use DbModels\Entities\Brand;
use League\Fractal\TransformerAbstract;

/**
 * Class BrandEntityTransformer
 * @package App\Data\Transformers
 */
class BrandEntityTransformer extends TransformerAbstract
{
    protected $availableIncludes = [
        'line',
    ];

    /**
     * @param Brand $item
     * @return array
     */
    public function transform(Brand $item)
    {
        $line = $item->getLine();
        $lineId = !!$line ? $line->getId() : null;

        return [
            'id' => (int)$item->getId(),
            'name' => $item->getName(),
            'code' => $item->getCode(),
            'lineId' => (int)$lineId,
            'regStatus' => (int)$item->getRegStatus(),
        ];
    }

    /**
     * @param Brand $item
     * @return \League\Fractal\Resource\Item|\League\Fractal\Resource\NullResource
     */
    public function includeLine(Brand $item)
    {
        if (!$item->getLine()) {
            return $this->null();
        }

        return $this->item($item->getLine(), new LineEntityTransformer);
    }
}