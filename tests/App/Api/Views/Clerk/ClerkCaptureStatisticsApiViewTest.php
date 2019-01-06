<?php
/**
 * Created by IntelliJ IDEA.
 * User: alberto
 * Date: 4/01/19
 * Time: 11:44 AM
 */

namespace Tests\App\Api\Views\Clerk;

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
 * Class ClerkCaptureStatisticsApiViewTest
 * @package Tests\App\Api\Views\Clerk
 */
class ClerkCaptureStatisticsApiViewTest extends DbUnitTestCase
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

        $request = TestUtils::makeServerRequestMock('GET', '/api/clerk/1/capture-statistics');
        $request = $request->withHeader(Http::HEADER_AUTHORIZATION, 'Bearer ' . $jwt);

        /** @var ResponseInterface $response */
        $response = $router->dispatch($request);

        TestUtils::runDefaultJsonViewResponseTests($this, $response);

        $body = (string)$response->getBody();
        $arrayBody = \json_decode($body, JSON_OBJECT_AS_ARRAY);

        $this->assertArrayHasKey('id', $arrayBody);
        $this->assertArrayHasKey('name', $arrayBody);
        $this->assertArrayHasKey('code', $arrayBody);
        $this->assertArrayHasKey('states', $arrayBody);

        $this->assertInternalType('int', $arrayBody['id']);
        $this->assertInternalType('string', $arrayBody['name']);
        $this->assertInternalType('string', $arrayBody['code']);
        $this->assertInternalType('array', $arrayBody['states']);

        $this->assertEquals(3, \count($arrayBody['states']));

        $state = $arrayBody['states'][0];

        // validate state reg structure
        $this->assertArrayHasKey('id', $state);
        $this->assertArrayHasKey('name', $state);
        $this->assertArrayHasKey('code', $state);
        $this->assertArrayHasKey('quant', $state);
        $this->assertArrayHasKey('shops', $state);

        $this->assertInternalType('int', $state['id']);
        $this->assertInternalType('string', $state['name']);
        $this->assertInternalType('string', $state['code']);
        $this->assertInternalType('int', $state['quant']);
        $this->assertInternalType('array', $state['shops']);

        // validate first state reg data
        $this->assertEquals(1, $state['id']);
        $this->assertEquals('AGUASCALIENTES', $state['name']);
        $this->assertEquals('1', $state['code']);
        $this->assertEquals(3, $state['quant']);
        $this->assertEquals(57, \count($state['shops']));

        // last store of first state, must have quant as 2
        $store = $state['shops'][56];

        // validate store reg structure
        $this->assertArrayHasKey('id', $store);
        $this->assertArrayHasKey('name', $store);
        $this->assertArrayHasKey('address', $store);
        $this->assertArrayHasKey('quant', $store);

        $this->assertInternalType('int', $store['id']);
        $this->assertInternalType('string', $store['name']);
        $this->assertInternalType('int', $store['quant']);
        $this->assertInternalType('string', $store['address']);

        // validate last store data (of first state)
        $this->assertEquals(2234, $store['id']);
        $this->assertEquals('WALMART MAHATMA GHANDI', $store['name']);
        $this->assertEquals(2, $store['quant']);
        $this->assertNotEmpty($store['address']);

        // just validate id and count for other states

        $state = $arrayBody['states'][1];

        $this->assertEquals(18, $state['id']);
        $this->assertEquals(11, $state['quant']);
        $this->assertEquals(33, \count($state['shops']));

        $state = $arrayBody['states'][2];

        $this->assertEquals(32, $state['id']);
        $this->assertEquals(0, $state['quant']);
        $this->assertEquals(24, \count($state['shops']));
    }

    /**
     * Returns the test dataset.
     *
     * @return IDataSet
     */
    protected function getDataSet()
    {
        $xmlFile = BASE_DIR . '/tests/dbunit-resources/api-clerk-capture-statistics-route.xml';
        return $this->createMySQLXMLDataSet($xmlFile);
    }
}