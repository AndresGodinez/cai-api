<?php
/**
 * Created by PhpStorm.
 * User: aGodinez
 * Date: 2019-01-03
 * Time: 10:19
 */

namespace App\Api\InventoryEvidence;


use App\Core\Config;
use App\Factories\ResponseFactory;
use DbModels\Entities\InventoryEvidence;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use function array_push;

class GetPhotosInventoryApiView
{

    /** @var Config */
    protected $config;

    /** @var EntityManagerInterface */
    protected $em;

    public function setConfig(Config $config): void
    {
        $this -> config = $config;
    }

    public function setEm(EntityManagerInterface $em): void
    {
        $this -> em = $em;
    }

    /**
     * @param ServerRequestInterface $request
     * @param array                  $args
     * @return ResponseInterface
     * @throws \Exception
     */
    public function __invoke(ServerRequestInterface $request, array $args): ResponseInterface
    {
        $params = $request -> getQueryParams();

        $repo = $this -> em -> getRepository(InventoryEvidence::class);

        $data = $repo -> getAllReportsPhotos($params);

        $uniqueRegisterInventory = [];

        foreach ($data as $item) {
            \array_push($uniqueRegisterInventory, $item['inventoryId']);
        }
        $uniqueRegisterInventory = \array_values(array_unique($uniqueRegisterInventory));
        $elements = [];

        foreach ($uniqueRegisterInventory as $inventoryId ) {
            $group = \array_filter($data, function ($item) use ($inventoryId){
                return $item['inventoryId'] === $inventoryId;
            });
            \array_push($elements, $group);
        }

        $orderElement = [];
        foreach ($elements as $element) {
            $keys = \array_keys($element);

            $firstElement = $element[$keys[0]];
            $secondElement = $element[$keys[1]];

            \array_push($orderElement, [
                'inventoryEvidencePhotos1' => $firstElement['inventoryEvidencePhotos'],
                'inventoryEvidencePhotos2' => $secondElement['inventoryEvidencePhotos'],
                'inventoryId' => $firstElement['inventoryId'],
                'inventoryCode' => $firstElement['inventoryCode'],
                'clerk_name' => $firstElement['clerk_name'],
                'clerkCode' => $firstElement['clerkCode'],
                'captureDate' => date_format($firstElement['captureDate'], "Y:m:d H:i:s"),
                'cityName' => $firstElement['cityName'],
                'storePostalCode' => $firstElement['storePostalCode'],
                'storeType' => $firstElement['storeType'],
                'storeName' => $firstElement['storeName'],
                'storeSapCode' => $firstElement['storeSapCode'],
                'storeAddress' => $firstElement['storeAddress'],
                'brandId' => $firstElement['brandId'],
                'brandName' => $firstElement['brandName'],
                'chainStore' => $firstElement['chainStore'],
                'furniture_name' => $firstElement['furniture_name'],
                'inventoryComment' => $firstElement['inventoryComment'],
                'storeId' => $firstElement['storeId']
            ]);

        }

        $response = ResponseFactory::buildBasicJsonResponse();
        $response->getBody()->write(\json_encode($orderElement));

        return $response;
    }
}
