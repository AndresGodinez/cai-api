<?php
/**
 * Created by IntelliJ IDEA.
 * User: alberto
 * Date: 4/01/19
 * Time: 10:17 AM
 */

namespace Tests\App\Api\Views\Indicator;

use App\Core\AppContainer;
use League\Route\Router;
use PHPUnit\DbUnit\DataSet\IDataSet;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface;
use Tests\ConfigurableConnectionTestTrait;
use Tests\DbUnitTestCase;
use Tests\TestUtils;

/**
 * Class ProgressPercByClerkApiViewTest
 * @package Tests\App\Api\Views\Indicator
 */
class ProgressPercByClerkApiViewTest extends DbUnitTestCase
{
    use ConfigurableConnectionTestTrait;

    /** @var ContainerInterface */
    private static $container;

    public static function setUpBeforeClass()
    {
        TestUtils::initConsts();

        self::$container = AppContainer::make(BASE_DIR);
    }

    public function testSuccessfullyResponse()
    {
        /** @var Router $router */
        $router = self::$container->get('router');

        $request = TestUtils::makeServerRequestMock('GET', '/api/indicator/progress-perc-by-clerk');

        /** @var ResponseInterface $response */
        $response = $router->dispatch($request);

        TestUtils::runDefaultJsonViewResponseTests($this, $response);

        $body = (string)$response->getBody();
        $arrayBody = \json_decode($body, JSON_OBJECT_AS_ARRAY);

        $this->assertEquals(4, count($arrayBody));

        $item = $arrayBody[0];

        $this->assertArrayHasKey('id', $item);
        $this->assertArrayHasKey('store_id', $item);
        $this->assertArrayHasKey('clerk_id', $item);
        $this->assertArrayHasKey('name', $item);
        $this->assertArrayHasKey('assigned_store_number', $item);
        $this->assertArrayHasKey('captured_store', $item);

        $this->assertEquals(1541, $item['id']);
        $this->assertEquals(1541, $item['store_id']);
        $this->assertEquals(1, $item['clerk_id']);
        $this->assertEquals('Alberto Medina Ortiz', $item['name']);
        $this->assertEquals(114, $item['assigned_store_number']);
        $this->assertEquals(14, $item['captured_store']);

        $item = $arrayBody[1];
        $this->assertEquals(1140, $item['id']);
        $this->assertEquals(1140, $item['store_id']);
        $this->assertEquals(5, $item['clerk_id']);
        $this->assertEquals('German Moreno Mendieta', $item['name']);
        $this->assertEquals(49, $item['assigned_store_number']);
        $this->assertEquals(9, $item['captured_store']);

        $item = $arrayBody[2];
        $this->assertEquals(176, $item['id']);
        $this->assertEquals(176, $item['store_id']);
        $this->assertEquals(6, $item['clerk_id']);
        $this->assertEquals('Edgar Alexander Mota', $item['name']);
        $this->assertEquals(86, $item['assigned_store_number']);
        $this->assertEquals(0, $item['captured_store']);

        $item = $arrayBody[3];
        $this->assertEquals(1665, $item['id']);
        $this->assertEquals(1665, $item['store_id']);
        $this->assertEquals(17, $item['clerk_id']);
        $this->assertEquals('Jesús Manuel López Correa', $item['name']);
        $this->assertEquals(51, $item['assigned_store_number']);
        $this->assertEquals(1, $item['captured_store']);
    }

    /**
     * Returns the test dataset.
     *
     * @return IDataSet
     */
    protected function getDataSet()
    {
        $xmlFile = BASE_DIR . '/tests/dbunit-resources/api-indicator-progress-perc-by-clerk-route.xml';
        return $this->createMySQLXMLDataSet($xmlFile);
    }
}