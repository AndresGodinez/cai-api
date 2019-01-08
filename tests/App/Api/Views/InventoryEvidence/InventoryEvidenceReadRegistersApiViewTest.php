<?php
/**
 * Created by IntelliJ IDEA.
 * User: alberto
 * Date: 27/12/18
 * Time: 04:29 PM
 */

namespace Tests\App\Api\Views\InventoryEvidence;

use App\Consts\Http;
use App\Core\AppContainer;
use DbModels\Consts\DefaultEntityRegStatus;
use DbModels\Consts\InventoryEvidencePhotoType;
use League\Route\Router;
use PHPUnit\DbUnit\DataSet\IDataSet;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface;
use Tests\ConfigurableConnectionTestTrait;
use Tests\DbUnitTestCase;
use Tests\TestUtils;

/**
 * Class InventoryEvidenceReadRegistersApiViewTest
 * @package Tests\App\Api\Views\InventoryEvidence
 */
class InventoryEvidenceReadRegistersApiViewTest extends DbUnitTestCase
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
        $jwt = 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpYXQiOjE1NDU0MjY3ODEsIm5iZiI6MTU0NTQyNjc4MSwic3ViIjoiNWMxZDU3NWRiY2ViNyIsInVzZXJJZCI6MiwibmFtZSI6IkltYW5vbCBIdW1iZXJ0byBSYW1cdTAwZWRyZXogTFx1MDBmM3BleiJ9.cc4MXPPjhTccbtYlR7Ad3U8ns372ve1VWMrc6ER2M2Q';

        /** @var Router $router */
        $router = self::$container->get('router');

        $request = TestUtils::makeServerRequestMock('GET', '/api/inventory-evidence', ['include' => 'photos', 'results' => 10, 'page' => 0]);
        $request = $request->withHeader(Http::HEADER_AUTHORIZATION, 'Bearer ' . $jwt);

        /** @var ResponseInterface $response */
        $response = $router->dispatch($request);

        TestUtils::runDefaultJsonViewResponseTests($this, $response);

        $body = (string)$response->getBody();
        $arrayBody = \json_decode($body, JSON_OBJECT_AS_ARRAY);

        $this->assertArrayHasKey('data', $arrayBody);
        $this->assertInternalType('array', $arrayBody['data']);

        $this->assertEquals(1, \count($arrayBody['data']));

        $item = $arrayBody['data'][0];
        $this->assertArrayHasKey('id', $item);
        $this->assertArrayHasKey('code', $item);
        $this->assertArrayHasKey('comments', $item);
        $this->assertArrayHasKey('storeId', $item);
        $this->assertArrayHasKey('brandId', $item);
        $this->assertArrayHasKey('furnitureTypeId', $item);
        $this->assertArrayHasKey('clerkId', $item);
        $this->assertArrayHasKey('userId', $item);
        $this->assertArrayHasKey('regStatus', $item);
        $this->assertArrayHasKey('photos', $item);

        $this->assertInternalType('int', $item['id']);
        $this->assertInternalType('string', $item['code']);
        $this->assertInternalType('string', $item['comments']);
        $this->assertInternalType('int', $item['storeId']);
        $this->assertInternalType('int', $item['brandId']);
        $this->assertInternalType('int', $item['furnitureTypeId']);
        $this->assertInternalType('int', $item['clerkId']);
        $this->assertInternalType('int', $item['userId']);
        $this->assertInternalType('int', $item['regStatus']);

        $this->assertEquals(1, $item['id']);
        $this->assertEquals('TEST', $item['code']);
        $this->assertEquals('TEST', $item['comments']);
        $this->assertEquals(1, $item['storeId']);
        $this->assertEquals(1, $item['brandId']);
        $this->assertEquals(1, $item['furnitureTypeId']);
        $this->assertEquals(3, $item['clerkId']);
        $this->assertEquals(2, $item['userId']);
        $this->assertEquals(DefaultEntityRegStatus::ACTIVE, $item['regStatus']);

        $photos = $item['photos']['data'];
        $this->assertEquals(2, \count($photos));

        $photo = $photos[0];
        $this->assertArrayHasKey('id', $photo);
        $this->assertArrayHasKey('filePath', $photo);
        $this->assertArrayHasKey('type', $photo);
        $this->assertEquals(InventoryEvidencePhotoType::FURNITURE, $photo['type']);

        $photo = $photos[1];
        $this->assertArrayHasKey('id', $photo);
        $this->assertArrayHasKey('filePath', $photo);
        $this->assertArrayHasKey('type', $photo);
        $this->assertEquals(InventoryEvidencePhotoType::QR, $photo['type']);
    }

    public function testRouteResponseSuccessfullyWithNoData()
    {
        $jwt = 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpYXQiOjE1NDU0MjY3ODEsIm5iZiI6MTU0NTQyNjc4MSwic3ViIjoiNWMxZDU3NWRiY2ViNyIsInVzZXJJZCI6MiwibmFtZSI6IkltYW5vbCBIdW1iZXJ0byBSYW1cdTAwZWRyZXogTFx1MDBmM3BleiJ9.cc4MXPPjhTccbtYlR7Ad3U8ns372ve1VWMrc6ER2M2Q';

        /** @var Router $router */
        $router = self::$container->get('router');

        $request = TestUtils::makeServerRequestMock('GET', '/api/inventory-evidence', ['include' => 'photos', 'results' => 10, 'page' => 1]);
        $request = $request->withHeader(Http::HEADER_AUTHORIZATION, 'Bearer ' . $jwt);

        /** @var ResponseInterface $response */
        $response = $router->dispatch($request);

        TestUtils::runDefaultJsonViewResponseTests($this, $response);

        $body = (string)$response->getBody();
        $arrayBody = \json_decode($body, JSON_OBJECT_AS_ARRAY);

        $this->assertArrayHasKey('data', $arrayBody);
        $this->assertInternalType('array', $arrayBody['data']);

        $this->assertEquals(0, \count($arrayBody['data']));
    }

    public function testErrorNoResultsParam()
    {
        $jwt = 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpYXQiOjE1NDU0MjY3ODEsIm5iZiI6MTU0NTQyNjc4MSwic3ViIjoiNWMxZDU3NWRiY2ViNyIsInVzZXJJZCI6MiwibmFtZSI6IkltYW5vbCBIdW1iZXJ0byBSYW1cdTAwZWRyZXogTFx1MDBmM3BleiJ9.cc4MXPPjhTccbtYlR7Ad3U8ns372ve1VWMrc6ER2M2Q';

        /** @var Router $router */
        $router = self::$container->get('router');

        $request = TestUtils::makeServerRequestMock('GET', '/api/inventory-evidence', ['include' => 'photos', 'page' => 1]);
        $request = $request->withHeader(Http::HEADER_AUTHORIZATION, 'Bearer ' . $jwt);

        /** @var ResponseInterface $response */
        $response = $router->dispatch($request);

        TestUtils::runDefaultJsonViewResponseTests($this, $response, Http::STATUS_CODE_HTTP_BAD_REQUEST);

        $body = (string)$response->getBody();
        $arrayBody = \json_decode($body, JSON_OBJECT_AS_ARRAY);

        $this->assertArrayHasKey('msg', $arrayBody);
        $this->assertInternalType('string', $arrayBody['msg']);

        $this->assertEqualsIgnoringCase('Los parámetros son inválidos.', $arrayBody['msg']);
    }

    public function testErrorNoPageParam()
    {
        $jwt = 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpYXQiOjE1NDU0MjY3ODEsIm5iZiI6MTU0NTQyNjc4MSwic3ViIjoiNWMxZDU3NWRiY2ViNyIsInVzZXJJZCI6MiwibmFtZSI6IkltYW5vbCBIdW1iZXJ0byBSYW1cdTAwZWRyZXogTFx1MDBmM3BleiJ9.cc4MXPPjhTccbtYlR7Ad3U8ns372ve1VWMrc6ER2M2Q';

        /** @var Router $router */
        $router = self::$container->get('router');

        $request = TestUtils::makeServerRequestMock('GET', '/api/inventory-evidence', ['include' => 'photos', 'results' => 10]);
        $request = $request->withHeader(Http::HEADER_AUTHORIZATION, 'Bearer ' . $jwt);

        /** @var ResponseInterface $response */
        $response = $router->dispatch($request);

        TestUtils::runDefaultJsonViewResponseTests($this, $response, Http::STATUS_CODE_HTTP_BAD_REQUEST);

        $body = (string)$response->getBody();
        $arrayBody = \json_decode($body, JSON_OBJECT_AS_ARRAY);

        $this->assertArrayHasKey('msg', $arrayBody);
        $this->assertInternalType('string', $arrayBody['msg']);

        $this->assertEqualsIgnoringCase('Los parámetros son inválidos.', $arrayBody['msg']);
    }

    /**
     * Returns the test dataset.
     *
     * @return IDataSet
     */
    protected function getDataSet()
    {
        $xmlFile = BASE_DIR . '/tests/dbunit-resources/api-inventory-evidence-read-registers-route.xml';
        return $this->createMySQLXMLDataSet($xmlFile);
    }
}