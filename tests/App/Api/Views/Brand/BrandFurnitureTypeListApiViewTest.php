<?php
/**
 * Created by IntelliJ IDEA.
 * User: alberto
 * Date: 6/01/19
 * Time: 01:28 PM
 */

namespace Tests\App\Api\Views\Brand;

use App\Consts\Http;
use App\Core\AppContainer;
use League\Route\Router;
use PHPUnit\DbUnit\DataSet\IDataSet;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface;
use Tests\ConfigurableConnectionTestTrait;
use Tests\DbUnitTestCase;
use Tests\TestUtils;

/**
 * Class BrandFurnitureTypeListApiViewTest
 * @package Tests\App\Api\Views\Brand
 */
class BrandFurnitureTypeListApiViewTest extends DbUnitTestCase
{
    use ConfigurableConnectionTestTrait;

    /** @var ContainerInterface */
    private static $container;

    public static function setUpBeforeClass()
    {
        TestUtils::initConsts();

        self::$container = AppContainer::make(BASE_DIR);
    }

    public function testRouteResponseSuccessfullyBrandNormal()
    {
        $jwt = 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpYXQiOjE1NDU0MjY3ODEsIm5iZiI6MTU0NTQyNjc4MSwic3ViIjoiNWMxZDU3NWRiY2ViNyIsInVzZXJJZCI6MiwibmFtZSI6IkltYW5vbCBIdW1iZXJ0byBSYW1cdTAwZWRyZXogTFx1MDBmM3BleiJ9.cc4MXPPjhTccbtYlR7Ad3U8ns372ve1VWMrc6ER2M2Q';

        /** @var Router $router */
        $router = self::$container->get('router');

        $request = TestUtils::makeServerRequestMock('GET', '/api/brand/1/furniture-type/list');
        $request = $request->withHeader(Http::HEADER_AUTHORIZATION, 'Bearer ' . $jwt);

        /** @var ResponseInterface $response */
        $response = $router->dispatch($request);

        TestUtils::runDefaultJsonViewResponseTests($this, $response);

        $body = (string)$response->getBody();
        $arrayBody = \json_decode($body, JSON_OBJECT_AS_ARRAY);

        $this->assertArrayHasKey('data', $arrayBody);
        $this->assertInternalType('array', $arrayBody['data']);

        $this->assertEquals(8, \count($arrayBody['data']));

        $item = $arrayBody['data'][0];
        $this->assertArrayHasKey('value', $item);
        $this->assertArrayHasKey('label', $item);

        $this->assertInternalType('int', $item['value']);
        $this->assertInternalType('string', $item['label']);

        $this->assertEquals(98, $item['value']);
        $this->assertEquals('RACK FACE 120X4', $item['label']);
    }

    public function testRouteResponseSuccessfullyBrandDelux()
    {
        $jwt = 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpYXQiOjE1NDU0MjY3ODEsIm5iZiI6MTU0NTQyNjc4MSwic3ViIjoiNWMxZDU3NWRiY2ViNyIsInVzZXJJZCI6MiwibmFtZSI6IkltYW5vbCBIdW1iZXJ0byBSYW1cdTAwZWRyZXogTFx1MDBmM3BleiJ9.cc4MXPPjhTccbtYlR7Ad3U8ns372ve1VWMrc6ER2M2Q';

        /** @var Router $router */
        $router = self::$container->get('router');

        $request = TestUtils::makeServerRequestMock('GET', '/api/brand/8/furniture-type/list');
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
        $this->assertArrayHasKey('value', $item);
        $this->assertArrayHasKey('label', $item);

        $this->assertInternalType('int', $item['value']);
        $this->assertInternalType('string', $item['label']);

        $this->assertEquals(132, $item['value']);
        $this->assertEquals('ISLA', $item['label']);
    }

    public function testRouteResponseSuccessfullyBrandActiveCosmetic()
    {
        $jwt = 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpYXQiOjE1NDU0MjY3ODEsIm5iZiI6MTU0NTQyNjc4MSwic3ViIjoiNWMxZDU3NWRiY2ViNyIsInVzZXJJZCI6MiwibmFtZSI6IkltYW5vbCBIdW1iZXJ0byBSYW1cdTAwZWRyZXogTFx1MDBmM3BleiJ9.cc4MXPPjhTccbtYlR7Ad3U8ns372ve1VWMrc6ER2M2Q';

        /** @var Router $router */
        $router = self::$container->get('router');

        $request = TestUtils::makeServerRequestMock('GET', '/api/brand/14/furniture-type/list');
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
        $this->assertArrayHasKey('value', $item);
        $this->assertArrayHasKey('label', $item);

        $this->assertInternalType('int', $item['value']);
        $this->assertInternalType('string', $item['label']);

        $this->assertEquals(132, $item['value']);
        $this->assertEquals('ISLA', $item['label']);
    }

    /**
     * Returns the test dataset.
     *
     * @return IDataSet
     */
    protected function getDataSet()
    {
        $xmlFile = BASE_DIR . '/tests/dbunit-resources/api-brand-furniture-type-list-route.xml';
        return $this->createMySQLXMLDataSet($xmlFile);
    }
}