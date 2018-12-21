<?php
/**
 * Created by IntelliJ IDEA.
 * User: alberto
 * Date: 21/12/18
 * Time: 02:46 PM
 */

namespace Tests\App\Api\Views;

use App\Consts\Http;
use App\Core\AppContainer;
use App\Utils\SecurityUtils;
use League\Route\Router;
use PHPUnit\DbUnit\Database\Connection;
use PHPUnit\DbUnit\DataSet\IDataSet;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface;
use Tests\ConfigurableConnectionTestTrait;
use Tests\DbUnitTestCase;
use Tests\TestUtils;

/**
 * Class UserDataApiViewTest
 * @package Tests\App\Api\Views
 */
class UserDataApiViewTest extends DbUnitTestCase
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

        $request = TestUtils::makeServerRequestMock('GET', '/api/user/2/data');
        $request = $request->withHeader(Http::HEADER_AUTHORIZATION, 'Bearer ' . $jwt);

        /** @var ResponseInterface $response */
        $response = $router->dispatch($request);

        TestUtils::runDefaultJsonViewResponseTests($this, $response);

        $body = (string)$response->getBody();
        $arrayBody = \json_decode($body, JSON_OBJECT_AS_ARRAY);

        $this->assertArrayHasKey('id', $arrayBody);
        $this->assertArrayHasKey('name', $arrayBody);
        $this->assertArrayHasKey('states', $arrayBody);

        $this->assertNotEmpty($arrayBody['id']);
        $this->assertNotEmpty($arrayBody['name']);

        $this->assertInternalType('int', $arrayBody['id']);
        $this->assertInternalType('string', $arrayBody['name']);
        $this->assertInternalType('array', $arrayBody['states']);

        $this->assertEquals(2, $arrayBody['id']);
        $this->assertEquals('Imanol Humberto Ramírez López', $arrayBody['name']);
        $this->assertEquals(1, \count($arrayBody['states']));

        $state = $arrayBody['states'][0];
        $this->assertArrayHasKey('id', $state);
        $this->assertArrayHasKey('name', $state);
        $this->assertArrayHasKey('code', $state);
        $this->assertArrayHasKey('shops', $state);

        $this->assertInternalType('int', $state['id']);
        $this->assertInternalType('string', $state['name']);
        $this->assertInternalType('string', $state['code']);
        $this->assertInternalType('array', $state['shops']);

        $this->assertEquals(5, $state['id']);
        $this->assertEquals('DISTRITO FEDERAL', $state['name']);
        $this->assertEquals('7', $state['code']);
        $this->assertEquals(154, \count($state['shops']));

        $shop0 = $state['shops'][0];
        $this->assertArrayHasKey('id', $shop0);
        $this->assertArrayHasKey('name', $shop0);

        $this->assertInternalType('int', $shop0['id']);
        $this->assertInternalType('string', $shop0['name']);

        $this->assertEquals(92, $shop0['id']);
        $this->assertEquals('CHEDRAUI CUAJIMALPA SUC 147', $shop0['name']);

        $shopLast = $state['shops'][153];
        $this->assertEquals(1433, $shopLast['id']);
        $this->assertEquals('NUEVA WALMART SC 3876 LAS AGUILA', $shopLast['name']);
    }

    /**
     * Returns the test dataset.
     *
     * @return IDataSet
     */
    protected function getDataSet()
    {
        $xmlFile = BASE_DIR . '/tests/dbunit-resources/api-user-data-route.xml';
        return $this->createMySQLXMLDataSet($xmlFile);
    }
}