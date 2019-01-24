<?php
/**
 * Created by PhpStorm.
 * User: aGodinez
 * Date: 2019-01-03
 * Time: 10:19
 */

namespace App\Api\InventoryEvidence;


use App\Core\Config;
use DateTime;
use DbModels\Entities\InventoryEvidence;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use function array_push;

class GetReportEvidenceApiView
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

        $data = $repo -> getAllReports($params);

        $orderElements = [];
        array_push($orderElements, ['idcaptura', 'Codigo de registro', 'Nombre Capturista', 'Codigo de Capturista', 'Fecha de Captura', 'Ciudad', 'Codigo Postal', 'Tipo de Tienda', 'Nombre de Tienda', 'Codigo Sap de Tienda', 'Direccion de la tienda', 'Identificador marca', 'Nombre Marca', 'Nombre de cadena', 'Tipo de mueble', 'Comentarios', 'Identificador de Tienda' ]);
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
        $date = new DateTime();
        $result = $date->format('Y-m-d H:i:s');
        $fileName = "AvanceDeCaptura".$result.".csv";
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
