<?php
/**
 * Created by IntelliJ IDEA.
 * User: alberto
 * Date: 22/12/18
 * Time: 11:29 AM
 */

namespace Tests\App\Api\Views\FurnitureType;

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
 * Class FurnitureTypeListApiViewTest
 * @package Tests\App\Api\Views\FurnitureType
 */
class FurnitureTypeListApiViewTest extends DbUnitTestCase
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

        $request = TestUtils::makeServerRequestMock('GET', '/api/furniture-type/list');
        $request = $request->withHeader(Http::HEADER_AUTHORIZATION, 'Bearer ' . $jwt);

        /** @var ResponseInterface $response */
        $response = $router->dispatch($request);

        TestUtils::runDefaultJsonViewResponseTests($this, $response);

        $body = (string)$response->getBody();
        $arrayBody = \json_decode($body, JSON_OBJECT_AS_ARRAY);

        $this->assertArrayHasKey('data', $arrayBody);
        $this->assertInternalType('array', $arrayBody['data']);

        $this->assertEquals(10, \count($arrayBody['data']));

        $item = $arrayBody['data'][0];
        $this->assertArrayHasKey('value', $item);
        $this->assertArrayHasKey('label', $item);

        $this->assertInternalType('int', $item['value']);
        $this->assertInternalType('string', $item['label']);

        $this->assertEquals(1, $item['value']);
        $this->assertEquals('TEST1', $item['label']);

        $itemLast = $arrayBody['data'][9];
        $this->assertEquals(10, $itemLast['value']);
        $this->assertEquals('TEST10', $itemLast['label']);
    }

    /**
     * Returns the test dataset.
     *
     * @return IDataSet
     */
    protected function getDataSet()
    {
        $xmlFile = BASE_DIR . '/tests/dbunit-resources/api-furniture-type-list-route.xml';
        return $this->createMySQLXMLDataSet($xmlFile);
    }
}