<?php
/**
 * Created by IntelliJ IDEA.
 * User: alberto
 * Date: 20/12/18
 * Time: 03:42 PM
 */

namespace Tests\App\Api\Views;

use App\Consts\Http;
use App\Core\AppContainer;
use App\Utils\SecurityUtils;
use League\Route\Router;
use PHPUnit\DbUnit\DataSet\IDataSet;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface;
use Tests\ConfigurableConnectionTestTrait;
use Tests\DbUnitTestCase;
use Tests\TestUtils;

/**
 * Class AuthApiViewTest
 * @package Tests\App\Api\Views
 */
class AuthApiViewTest extends DbUnitTestCase
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
        /** @var Router $router */
        $router = self::$container->get('router');

        $data = [
            'username' => 'admin',
            'pswd' => 'test',
        ];
        $request = TestUtils::makeServerRequestMock('POST', '/api/auth', [], $data);

        /** @var ResponseInterface $response */
        $response = $router->dispatch($request);

        TestUtils::runDefaultJsonViewResponseTests($this, $response);

        $body = (string)$response->getBody();
        $arrayBody = \json_decode($body, JSON_OBJECT_AS_ARRAY);

        $this->assertArrayHasKey('msg', $arrayBody);
        $this->assertArrayHasKey('token', $arrayBody);
        $this->assertArrayHasKey('userId', $arrayBody);

        $this->assertNotEmpty($arrayBody['msg']);
        $this->assertNotEmpty($arrayBody['token']);
        $this->assertEquals(1, $arrayBody['userId']);

        $re = '/^([a-zA-Z0-9_=]+)\.([a-zA-Z0-9_=]+)\.([a-zA-Z0-9_\-\+\/=]*)$/m';
        $this->assertRegExp($re, $arrayBody['token']);

        $secret = $this->config->get('APP_JWT_SECRET', '');
        $this->assertTrue(SecurityUtils::validateJwt($secret, $arrayBody['token']));
    }

    public function testErrorNoParamUsername()
    {
        /** @var Router $router */
        $router = self::$container->get('router');

        $data = [
            'pswd' => 'test',
        ];
        $request = TestUtils::makeServerRequestMock('POST', '/api/auth', [], $data);

        /** @var ResponseInterface $response */
        $response = $router->dispatch($request);

        TestUtils::runDefaultJsonViewResponseTests($this, $response, Http::STATUS_CODE_HTTP_BAD_REQUEST);

        $body = (string)$response->getBody();
        $arrayBody = \json_decode($body, JSON_OBJECT_AS_ARRAY);

        $this->assertArrayHasKey('msg', $arrayBody);
    }

    public function testErrorNoParamPswd()
    {
        /** @var Router $router */
        $router = self::$container->get('router');

        $data = [
            'username' => 'admin',
        ];
        $request = TestUtils::makeServerRequestMock('POST', '/api/auth', [], $data);

        /** @var ResponseInterface $response */
        $response = $router->dispatch($request);

        TestUtils::runDefaultJsonViewResponseTests($this, $response, Http::STATUS_CODE_HTTP_BAD_REQUEST);

        $body = (string)$response->getBody();
        $arrayBody = \json_decode($body, JSON_OBJECT_AS_ARRAY);

        $this->assertArrayHasKey('msg', $arrayBody);
    }

    public function testErrorInvalidUsername()
    {
        /** @var Router $router */
        $router = self::$container->get('router');

        $data = [
            'username' => 'aadmin',
            'pswd' => 'test',
        ];
        $request = TestUtils::makeServerRequestMock('POST', '/api/auth', [], $data);

        /** @var ResponseInterface $response */
        $response = $router->dispatch($request);

        TestUtils::runDefaultJsonViewResponseTests($this, $response, Http::STATUS_CODE_HTTP_BAD_REQUEST);

        $body = (string)$response->getBody();
        $arrayBody = \json_decode($body, JSON_OBJECT_AS_ARRAY);

        $this->assertArrayHasKey('msg', $arrayBody);
    }

    public function testErrorInvalidPswd()
    {
        /** @var Router $router */
        $router = self::$container->get('router');

        $data = [
            'username' => 'admin',
            'pswd' => 'ttest',
        ];
        $request = TestUtils::makeServerRequestMock('POST', '/api/auth', [], $data);

        /** @var ResponseInterface $response */
        $response = $router->dispatch($request);

        TestUtils::runDefaultJsonViewResponseTests($this, $response, Http::STATUS_CODE_HTTP_BAD_REQUEST);

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
        $xmlFile = BASE_DIR . '/tests/dbunit-resources/api-auth-route.xml';
        return $this->createMySQLXMLDataSet($xmlFile);
    }
}