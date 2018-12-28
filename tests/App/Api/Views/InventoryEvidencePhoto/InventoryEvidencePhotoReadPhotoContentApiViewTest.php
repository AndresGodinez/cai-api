<?php
/**
 * Created by IntelliJ IDEA.
 * User: alberto
 * Date: 27/12/18
 * Time: 06:48 PM
 */

namespace Tests\App\Api\Views\InventoryEvidencePhoto;

use App\Consts\Http;
use App\Core\AppContainer;
use League\Flysystem\FilesystemInterface;
use League\Route\Router;
use PHPUnit\DbUnit\Database\Connection;
use PHPUnit\DbUnit\DataSet\IDataSet;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface;
use Tests\ConfigurableConnectionTestTrait;
use Tests\DbUnitTestCase;
use Tests\TestUtils;

/**
 * Class InventoryEvidencePhotoReadPhotoContentApiViewTest
 * @package Tests\App\Api\Views\InventoryEvidencePhoto
 */
class InventoryEvidencePhotoReadPhotoContentApiViewTest extends DbUnitTestCase
{
    use ConfigurableConnectionTestTrait;

    /** @var ContainerInterface */
    private static $container;

    public static function setUpBeforeClass()
    {
        TestUtils::initConsts();

        self::$container = AppContainer::make(BASE_DIR);

        // set inventory-evidence-photos path
        $photosStorageDir = BASE_DIR . "/tests/test-storage/inventory-evidence-photos";
        if (\file_exists($photosStorageDir)) {
            TestUtils::deleteDir($photosStorageDir);
        }
    }

    public function testRouteResponseSuccessfully()
    {
        $photosStorageDir = BASE_DIR . "/tests/test-storage/inventory-evidence-photos";
        $this->assertDirectoryNotExists($photosStorageDir);

        $this->assertTableRowCount('s30_inventory_evidences', 1);
        $this->assertTableRowCount('s30_inventory_evidence_photos', 2);

        /** @var FilesystemInterface $photosStorage */
        $photosStorage = self::$container->get('inventory-evidence-photos-filesystem');

        /** @var Connection $conn */
        $conn = $this->getConnection();

        $testTablePhotos = $conn->createQueryTable('testTablePhotos', 'select a.file_path from s30_inventory_evidence_photos a');

        $photoRow = $testTablePhotos->getRow(0);
        $photosStorage->put($photoRow['file_path'], \file_get_contents(BASE_DIR . '/tests/files-resources/furniture-test-001.jpeg'));
        $this->assertFileExists($photosStorageDir . $photoRow['file_path']);

        $photoRow = $testTablePhotos->getRow(1);
        $photosStorage->put($photoRow['file_path'], \file_get_contents(BASE_DIR . '/tests/files-resources/qrcode-test-001.jpeg'));
        $this->assertFileExists($photosStorageDir . $photoRow['file_path']);
        
        $jwt = 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpYXQiOjE1NDU0MjY3ODEsIm5iZiI6MTU0NTQyNjc4MSwic3ViIjoiNWMxZDU3NWRiY2ViNyIsInVzZXJJZCI6MiwibmFtZSI6IkltYW5vbCBIdW1iZXJ0byBSYW1cdTAwZWRyZXogTFx1MDBmM3BleiJ9.cc4MXPPjhTccbtYlR7Ad3U8ns372ve1VWMrc6ER2M2Q';
        $a = \base64_encode($jwt);

        /** @var Router $router */
        $router = self::$container->get('router');

        $request = TestUtils::makeServerRequestMock('GET', '/api/inventory-evidence-photo/1', ['a' => $a]);

        /** @var ResponseInterface $response */
        $response = $router->dispatch($request);

        TestUtils::runDefaulImageJpegResponseTests($this, $response);

        /** @var Router $router */
        $router = self::$container->get('router');

        $request = TestUtils::makeServerRequestMock('GET', '/api/inventory-evidence-photo/2', ['a' => $a]);

        /** @var ResponseInterface $response */
        $response = $router->dispatch($request);

        TestUtils::runDefaulImageJpegResponseTests($this, $response);
    }

    /**
     * Returns the test dataset.
     *
     * @return IDataSet
     */
    protected function getDataSet()
    {
        $xmlFile = BASE_DIR . '/tests/dbunit-resources/api-inventory-evidence-photo-read-photo-content-route.xml';
        return $this->createMySQLXMLDataSet($xmlFile);
    }
}