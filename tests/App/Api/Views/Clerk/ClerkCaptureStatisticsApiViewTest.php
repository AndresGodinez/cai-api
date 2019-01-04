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

        $this->assertNotEmpty($arrayBody['id']);
        $this->assertNotEmpty($arrayBody['name']);
        $this->assertNotEmpty($arrayBody['code']);

        $this->assertInternalType('int', $arrayBody['id']);
        $this->assertInternalType('string', $arrayBody['name']);
        $this->assertInternalType('string', $arrayBody['code']);
        $this->assertInternalType('array', $arrayBody['states']);
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