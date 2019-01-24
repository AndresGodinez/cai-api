<?php
/**
 * Created by PhpStorm.
 * User: aGodinez
 * Date: 2019-01-18
 * Time: 15:46
 */

namespace App\Api\InventoryEvidence;


namespace App\Api\InventoryEvidence;


use App\Core\Config;
use DateTime;
use DbModels\Entities\Store;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

use function array_push;

class PendingStoreReportApiView
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

        $repo = $this -> em -> getRepository(Store::class);

        $data = $repo -> getPendingStores($params);

        $orderElements = [];

        array_push($orderElements, ['Identificador de tienda', 'Nombre Tienda', 'SapCode','Ciudad', 'Codigo Postal',
            'Tipo de tienda', 'Direccion', 'Cadena Comercial']);

        foreach ($data as $item) {
            $element = [

                'storeId' => $item['storeId'],
                'storeName' => $item['storeName'],
                'sapCode' => $item['storeSapCode'],
                'storeCityName' => $item['storeCityName'],
                'storePostalCode' => $item['storePostalCode'],
                'storeType' => $item['storeType'],
                'storeAddress' => $item['storeAddress'],
                'ChainStoreName' => $item['ChainStoreName'],

            ];
            array_push($orderElements, $element);
        }
        $date = new DateTime();
        $result = $date->format('Y-m-d H:i:s');

        $fileName = 'TiendasPendientes'.$result.'.csv';
        header('Content-Type: application/excel');
        header('Content-Disposition: attachment; filename="' . $fileName . '"');
        $fp = fopen('php://output', 'w');

        foreach ($orderElements as $row) {
            fputcsv($fp, $row);
        }

        fclose($fp);

        die();
    }
}
