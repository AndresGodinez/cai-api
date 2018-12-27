<?php
/**
 * Created by IntelliJ IDEA.
 * User: alberto
 * Date: 27/12/18
 * Time: 10:51 AM
 */

namespace Tests\App\Api\Views\InventoryEvidence;

use App\Consts\Http;
use App\Core\AppContainer;
use App\Utils\SecurityUtils;
use DbModels\Consts\DefaultEntityRegStatus;
use DbModels\Consts\InventoryEvidencePhotoType;
use League\Route\Router;
use PHPUnit\DbUnit\Database\Connection;
use PHPUnit\DbUnit\DataSet\IDataSet;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface;
use Tests\ConfigurableConnectionTestTrait;
use Tests\DbUnitTestCase;
use Tests\TestUtils;
use Zend\Diactoros\Stream;
use Zend\Diactoros\UploadedFile;

/**
 * Class InventoryEvidenceCreateApiViewTest
 * @package Tests\App\Api\Views\InventoryEvidence
 */
class InventoryEvidenceCreateApiViewTest extends DbUnitTestCase
{
    use ConfigurableConnectionTestTrait;

    /** @var ContainerInterface */
    private static $container;

    public static function setUpBeforeClass()
    {
        TestUtils::initConsts();

        self::$container = AppContainer::make(BASE_DIR);
    }

    public function testRouteResponseSuccessfully()
    {
        $config = self::$container->get('model-config');
        $secret = $config->get('APP_JWT_SECRET');

        $jwt = 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpYXQiOjE1NDU0MjY3ODEsIm5iZiI6MTU0NTQyNjc4MSwic3ViIjoiNWMxZDU3NWRiY2ViNyIsInVzZXJJZCI6MiwibmFtZSI6IkltYW5vbCBIdW1iZXJ0byBSYW1cdTAwZWRyZXogTFx1MDBmM3BleiJ9.cc4MXPPjhTccbtYlR7Ad3U8ns372ve1VWMrc6ER2M2Q';

        /** @var Router $router */
        $router = self::$container->get('router');

        $code = 'TEST';
        $comments = 'TEST';
        $storeId = 1;
        $brandId = 1;
        $furnitureTypeId = 1;
        $clerkId = 3;

        $jwtData = SecurityUtils::decodeJwtData($secret, $jwt);
        $userId = $jwtData->userId;

        $bodyData = [
            'code' => $code,
            'comments' => $comments,
            'storeId' => $storeId,
            'brandId' => $brandId,
            'furnitureTypeId' => $furnitureTypeId,
            'clerkId' => $clerkId,
        ];

        $photoFurnitureStream = new Stream(BASE_DIR . "/tests/files-resources/furniture-test-001.jpeg", 'r');
        $photoFurnitureStreamSize = $photoFurnitureStream->getSize();

        $photoQrcodeStream = new Stream(BASE_DIR . "/tests/files-resources/qrcode-test-001.jpeg", 'r');
        $photoQrcodeStreamSize = $photoQrcodeStream->getSize();

        $photoFurniture = new UploadedFile($photoFurnitureStream, $photoFurnitureStreamSize, 0, "furniture-test-001.jpeg", "image/jpeg");
        $photoQrcode = new UploadedFile($photoQrcodeStream, $photoQrcodeStreamSize, 0, "qrcode-test-001.jpeg", "image/jpeg");

        $request = TestUtils::makeServerRequestMock('POST', '/api/inventory-evidence', [], $bodyData);
        $request = $request->withHeader(Http::HEADER_AUTHORIZATION, 'Bearer ' . $jwt);
        $request = $request->withUploadedFiles([
            'photo-furniture' => $photoFurniture,
            'photo-qrcode' => $photoQrcode,
        ]);

        /** @var ResponseInterface $response */
        $response = $router->dispatch($request);

        TestUtils::runDefaultJsonViewResponseTests($this, $response);

        $body = (string)$response->getBody();
        $arrayBody = \json_decode($body, JSON_OBJECT_AS_ARRAY);

        $this->assertArrayHasKey('id', $arrayBody);
        $this->assertArrayHasKey('msg', $arrayBody);
        $this->assertInternalType('int', $arrayBody['id']);
        $this->assertInternalType('string', $arrayBody['msg']);

        // check db registers
        $this->assertTableRowCount('s30_inventory_evidences', 1);
        $this->assertTableRowCount('s30_inventory_evidence_photos', 2);

        /** @var Connection $conn */
        $conn = $this->getConnection();

        $testTable = $conn->createQueryTable('testTable', 'select a.id, a.code, a.comments, a.store_id, a.brand_id, a.furniture_type_id, a.clerk_id, a.user_id, a.reg_status from s30_inventory_evidences a');

        $this->assertTableContains(
            [
                'id' => (int)$arrayBody['id'],
                'code' => $code,
                'comments' => $comments,
                'store_id' => $storeId,
                'brand_id' => $brandId,
                'furniture_type_id' => $furnitureTypeId,
                'clerk_id' => $clerkId,
                'user_id' => $userId,
                'reg_status' => DefaultEntityRegStatus::ACTIVE,
            ],
            $testTable
        );

        $testTablePhotos = $conn->createQueryTable('testTablePhotos', 'select a.type, a.inventory_evidence_id from s30_inventory_evidence_photos a');

        $this->assertTableContains(
            [
                'type' => InventoryEvidencePhotoType::FURNITURE,
                'inventory_evidence_id' => (int)$arrayBody['id'],
            ],
            $testTablePhotos
        );
        $this->assertTableContains(
            [
                'type' => InventoryEvidencePhotoType::QR,
                'inventory_evidence_id' => (int)$arrayBody['id'],
            ],
            $testTablePhotos
        );
    }

    /**
     * Returns the test dataset.
     *
     * @return IDataSet
     */
    protected function getDataSet()
    {
        $xmlFile = BASE_DIR . '/tests/dbunit-resources/api-inventory-evidence-create-route.xml';
        return $this->createMySQLXMLDataSet($xmlFile);
    }
}