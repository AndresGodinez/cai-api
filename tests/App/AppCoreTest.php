<?php
/**
 * Created by IntelliJ IDEA.
 * User: alberto
 * Date: 26/11/18
 * Time: 03:09 PM
 */


namespace Tests\App;


use App\Core\AppContainer;
use App\Core\Config;
use League\Container\Container;
use League\Route\Router;
use PHPUnit\Framework\TestCase;
use Tests\TestUtils;


class AppCoreTest extends TestCase
{
    public static function setUpBeforeClass()
    {
        TestUtils::initConsts();
    }

    public function testCanInstanceAppContainer()
    {
        $container = AppContainer::make(BASE_DIR);

        $this->assertNotNull($container);
        $this->assertInstanceOf(Container::class, $container);
    }

    public function testCanInstanceModelConfig()
    {
        $container = AppContainer::make(BASE_DIR);

        /** @var Config $config */
        $config = $container->get('model-config');

        $this->assertNotNull($config);
        $this->assertInstanceOf(Config::class, $config);
    }

    public function testCanInstanceAppRouter()
    {
        $container = AppContainer::make(BASE_DIR);

        $inst = $container->get('router');

        $this->assertNotNull($inst);
        $this->assertInstanceOf(Router::class, $inst);
    }

    public function testAppRouterContainTestRoute()
    {
        $container = AppContainer::make(BASE_DIR);

        /** @var Router $inst */
        $inst = $container->get('router');

        $this->assertInstanceOf(Router::class, $inst);

        $route = $inst->getNamedRoute('api-test');

        $this->assertNotNull($route);
        $this->assertEquals('/test', $route->getPath());
        $this->assertEquals('GET', $route->getMethod());
    }
}
