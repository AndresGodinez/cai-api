<?php
/**
 * Created by IntelliJ IDEA.
 * User: alberto
 * Date: 5/01/19
 * Time: 10:17 PM
 */

namespace App\Data\Transformers;

use App\Data\Models\ClerkCaptureStatisticData;
use League\Fractal\TransformerAbstract;

/**
 * Class ClerkCaptureStatisticDataTransformer
 * @package App\Data\Transformers
 */
class ClerkCaptureStatisticDataTransformer extends TransformerAbstract
{
    /**
     * @param ClerkCaptureStatisticData $item
     * @return array
     */
    public function transform(ClerkCaptureStatisticData $item)
    {
        $states = $item->getStatesData();
        $clerk = $item->getClerk();

        return [
            'id' => (int)$clerk->getId(),
            'name' => $clerk->getName(),
            'code' => $clerk->getCode(),
            'states' => $states,
        ];
    }
}