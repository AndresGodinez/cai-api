<?php
/**
 * Created by PhpStorm.
 * User: aGodinez
 * Date: 2019-01-03
 * Time: 10:19
 */

namespace App\Api\InventoryEvidence;


use App\Core\Config;
use const BASE_DIR;
use DbModels\Entities\InventoryEvidence;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use ZipArchive;

class GetPhotoZipApiView
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
        $data = $repo -> getInfoPhotosToZip($params);

        $orderElements = [];
        $infoPath = BASE_DIR.'/storage/inventory-evidence-photos';
        foreach ($data as $item) {
            $element = [
                'filePath' => $infoPath.$item['filePath'],
            ];
            \array_push($orderElements, $element);
        }

        $zip = new ZipArchive();
        $filename = 'DownloadPhotos.zip';
        if($zip->open($filename,ZIPARCHIVE::CREATE)===true) {
            foreach ($orderElements as $element) {
                $zip->addFile($element['filePath']);
            }
        $zip->close();
        error_log(print_r("creado", true));
        }
        else {
            error_log(print_r("Error al crear archivo", true));
        }


        header("Content-type: application/octet-stream");
        header("Content-disposition: attachment; filename=DownloadPhotos.zip");
        readfile('DownloadPhotos.zip');
        unlink('DownloadPhotos.zip');

        die();
    }
}
