<?php
/**
 * Created by PhpStorm.
 * User: aGodinez
 * Date: 2019-01-03
 * Time: 10:19
 */

namespace App\Api\InventoryEvidence;


use App\Core\Config;
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
     */
    public function __invoke(ServerRequestInterface $request, array $args): ResponseInterface
    {
        $params = $request -> getQueryParams();

        $repo = $this -> em -> getRepository(InventoryEvidence::class);

        $data = $repo -> getAllReports($params);
        $orderElements = [];
        array_push($orderElements, ['idcaptura', 'Codigo registro', 'Nombre Capturista', 'Codigo Capturista',
            'Fecha Captura', 'Ciudad', 'Codigo postal', 'Nombre de tienda', 'Identificador de tienda', 'Direccion', 'Tipo Tienda',
            'Nombre Marca', 'Nombre Cadena', 'Tipo de mueble', 'Comentario']);
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
                'storeName' => $item['storeName'],
                'storeId' => $item['storeId'],
                'storeAddress' => $item['storeAddress'],
                'storeType' => $item['storeType'],
                'brandName' => $item['brandName'],
                'chainStore' => $item['chainStore'],
                'furniture_name' => $item['furniture_name'],
                'inventoryComment' => $item['inventoryComment'],
            ];
            array_push($orderElements, $element);
        }

        $fileName = 'example.csv';
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