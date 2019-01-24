<?php
/**
 * Created by IntelliJ IDEA.
 * User: alberto
 * Date: 4/01/19
 * Time: 10:15 AM
 */

namespace App\Api\Indicator;

use App\Core\Config;
use App\Factories\ResponseFactory;
use function array_push;
use function array_unique;
use function array_values;
use DbModels\Entities\InventoryEvidence;
use DbModels\Entities\StoreClerk;
use DbModels\Repositories\StoreClerkRepository;
use Doctrine\ORM\EntityManagerInterface;
use function in_array;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

/**
 * Class ProgressPercByStateApiView
 * @package App\Api\Indicator
 */
class ProgressPercByStateApiView
{
    /** @var Config */
    protected $config;

    /** @var EntityManagerInterface */
    protected $em;

    public function setConfig(Config $config): void
    {
        $this->config = $config;
    }

    public function setEm(EntityManagerInterface $em): void
    {
        $this->em = $em;
    }

    /**
     * @param ServerRequestInterface $request
     * @param array $args
     * @return ResponseInterface
     */
    public function __invoke(ServerRequestInterface $request, array $args) : ResponseInterface
    {
        /** @var StoreClerkRepository $repo */
        $repo = $this->em->getRepository(StoreClerk::class);

        $data = $repo->getProgressPercByStateData();

        $repo2 = $this->em->getRepository(InventoryEvidence::class);

        $data2 = $repo2->getProgressState();

        $idState = [];

        foreach ($data2 as $item) {
            array_push($idState, $item['stateId']);
        }
        $uniqueStateId = array_values(array_unique($idState));

        $groupElements = [];

        foreach ($uniqueStateId as $stateId) {
            $totalsByState = \array_filter($data2, function ($item) use ($stateId) {
                return $item['stateId'] === $stateId;
            });

            $storeState = [];
            $uniqueStoreId = [];

            foreach ($totalsByState as $totalState) {
                if (!\in_array($totalState['storeId'], $uniqueStoreId)){
                    array_push($uniqueStoreId, $totalState['storeId']);
                    array_push($storeState, $totalState);
                }
            }

            array_push($groupElements, [
                'idState' => $storeState[0]['stateId'],
                'stateName' => $storeState[0]['stateName'],
                'quantity' => $quantity =  count($storeState)
            ]);
        }

        $orderData = [];
        foreach ($data as $item) {
            $element =[
                'stateId' => $item['stateId'],
                'stateName' => $item['stateName'],
                'assignedStoreNumber' => $item['assignedStoreNumber'],
                'capturedStore' => 0
            ];
            array_push($orderData, $element);
        }


        for ($i=0; $i < count($orderData); $i++){
            for ($j=0; $j < count($groupElements); $j++){
                if($orderData[$i]['stateId']=== $groupElements[$j]['idState']){
                    $orderData[$i]['capturedStore'] = $groupElements[$j]['quantity'];
                }
            }

        }

        $response = ResponseFactory::buildBasicJsonResponse();
        $response->getBody()->write(\json_encode($orderData));

        return $response;
    }
}
