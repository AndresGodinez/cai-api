<?php
/**
 * Created by IntelliJ IDEA.
 * User: alberto
 * Date: 4/01/19
 * Time: 11:43 AM
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
 * Class ClerkCaptureStatisticsApiViewBadAuthorizationTest
 * @package Tests\App\Api\Views\Clerk
 */
class ClerkCaptureStatisticsApiViewBadAuthorizationTest extends DbUnitTestCase
{
    use ConfigurableConnectionTestTrait;

    /** @var ContainerInterface */
    private static $container;

    public static function setUpBeforeClass()
    {
        TestUtils::initConsts();

        self::$container = AppContainer::make(BASE_DIR);
    }

    public function testErrorNoAuthorizationHeader()
    {
        /** @var Router $router */
        $router = self::$container->get('router');

        $request = TestUtils::makeServerRequestMock('GET', '/api/clerk/1/capture-statistics');

        /** @var ResponseInterface $response */
        $response = $router->dispatch($request);

        TestUtils::runDefaultJsonViewResponseTests($this, $response, Http::STATUS_CODE_HTTP_UNAUTHORIZED);

        $body = (string)$response->getBody();
        $arrayBody = \json_decode($body, JSON_OBJECT_AS_ARRAY);

        $this->assertArrayHasKey('msg', $arrayBody);
    }

    public function testErrorBadAuthorizationHeaderEmpty()
    {
        /** @var Router $router */
        $router = self::$container->get('router');

        $request = TestUtils::makeServerRequestMock('GET', '/api/clerk/1/capture-statistics');
        $request = $request->withHeader(Http::HEADER_AUTHORIZATION, '');

        /** @var ResponseInterface $response */
        $response = $router->dispatch($request);

        TestUtils::runDefaultJsonViewResponseTests($this, $response, Http::STATUS_CODE_HTTP_UNAUTHORIZED);

        $body = (string)$response->getBody();
        $arrayBody = \json_decode($body, JSON_OBJECT_AS_ARRAY);

        $this->assertArrayHasKey('msg', $arrayBody);
    }

    public function testErrorBadAuthorizationHeaderIncorrect()
    {
        $jwt = 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpYXQiOjE1NDU0MjY3ODEsIm5iZiI6MTU0NTQyNjc4MSwic3ViIjoiNWMxZDU3NWRiY2ViNyIsInVzZXJJZCI6MiwibmFtZSI6IkltYW5vbCBIdW1iZXJ0byBSYW1cdTAwZWRyZXogTFx1MDBmM3BleiJ9';

        /** @var Router $router */
        $router = self::$container->get('router');

        $request = TestUtils::makeServerRequestMock('GET', '/api/clerk/1/capture-statistics');
        $request = $request->withHeader(Http::HEADER_AUTHORIZATION, $jwt);

        /** @var ResponseInterface $response */
        $response = $router->dispatch($request);

        TestUtils::runDefaultJsonViewResponseTests($this, $response, Http::STATUS_CODE_HTTP_UNAUTHORIZED);

        $body = (string)$response->getBody();
        $arrayBody = \json_decode($body, JSON_OBJECT_AS_ARRAY);

        $this->assertArrayHasKey('msg', $arrayBody);
    }

    /**
     * Returns the test dataset.
     *
     * @return IDataSet
     */
    protected function getDataSet()
    {
        $xmlFile = BASE_DIR . '/tests/dbunit-resources/api-bad-auth-route.xml';
        return $this->createMySQLXMLDataSet($xmlFile);
    }
}