<?php
/**
 * Created by IntelliJ IDEA.
 * User: alberto
 * Date: 5/01/19
 * Time: 10:17 PM
 */

namespace App\Data\Models;

use DbModels\Entities\Clerk;

/**
 * Class ClerkCaptureStatisticData
 * @package App\Data\Models
 */
class ClerkCaptureStatisticData
{
    /** @var Clerk */
    protected $clerk;

    /** @var array */
    protected $data;

    /** @var array */
    protected $statesData;

    /**
     * ClerkCaptureStatisticData constructor.
     * @param Clerk $clerk
     * @param array $data
     */
    public function __construct(Clerk $clerk, array $data)
    {
        $this->clerk = $clerk;
        $this->data = $data;

        $this->initStatesData();
    }

    private function initStatesData()
    {
        $states = [];

        $length = \count($this->data);

        for ($i = 0; $i < $length; $i++) {
            $item = $this->data[$i];

            if (!\array_key_exists($item['stateId'], $states)) {
                $states[$item['stateId']] = [
                    'id' => (int)$item['stateId'],
                    'name' => $item['stateName'],
                    'code' => $item['stateCode'],
                    'quant' => 0,
                    'shops' => [],
                ];
            }

            $capturedQuant = (int)$item['capturedQuant'];
            \array_push($states[$item['stateId']]['shops'], [
                'id' => (int)$item['storeId'],
                'name' => $item['storeName'],
                'address' => $item['storeAddress'],
                'quant' => $capturedQuant,
            ]);

            $states[$item['stateId']]['quant'] += $capturedQuant;
        }

        $this->statesData = \array_values($states);
    }

    /**
     * @return Clerk
     */
    public function getClerk(): Clerk
    {
        return $this->clerk;
    }

    /**
     * @return array
     */
    public function getData(): array
    {
        return $this->data;
    }

    /**
     * @return array
     */
    public function getStatesData(): array
    {
        return $this->statesData;
    }
}