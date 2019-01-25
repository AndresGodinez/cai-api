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

        $orderElements = [];
        foreach ($data as $item) {
            if ($item['inventoryComment'] === 'undefined' || $item['inventoryComment'] === 'null')
                $item['inventoryComment'] = "Sin comentarios";
            $element = [
                'inventoryId' => $item['inventoryId'],
                'inventoryCode' => $item['inventoryCode'],
                'clerk_name' => $item['clerk_name'],
                'clerkCode' => $item['clerkCode'],
                'captureDate' => $item['captureDate'] -> format('Y-m-d H:i:s'),
                'cityName' => $item['cityName'],
                'storePostalCode' => $item['storePostalCode'],
                'storeType' => $item['storeType'],
                'storeName' => $item['storeName'],
                'storeSapCode' => $item['storeSapCode'],
                'storeAddress' => $item['storeAddress'],
                'brandId' => $item['brandId'],
                'brandName' => $item['brandName'],
                'chainStore' => $item['chainStore'],
                'furniture_name' => $item['furniture_name'],
                'inventoryComment' => $item['inventoryComment'],
                'storeId' => $item['storeId'],
            ];
            array_push($orderElements, $element);
        }
        $response = ResponseFactory::buildBasicJsonResponse();
        $response->getBody()->write(\json_encode($orderElements));

        return $response;
    }
}
