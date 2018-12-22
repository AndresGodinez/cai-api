<?php
/**
 * Created by IntelliJ IDEA.
 * User: alberto
 * Date: 22/12/18
 * Time: 11:28 AM
 */

namespace Tests\App\Routes;

use App\Core\AppContainer;
use League\Route\Router;
use PHPUnit\Framework\TestCase;
use Tests\TestUtils;

/**
 * Class FurnitureTypeRoutesTest
 * @package Tests\App\Routes
 */
class FurnitureTypeRoutesTest extends TestCase
{
    public static function setUpBeforeClass()
    {
        TestUtils::initConsts();
    }

    public function testAppRouterContainsBrandListRoute()
    {
        $container = AppContainer::make(BASE_DIR);

        /** @var Router $inst */
        $inst = $container->get('router');

        $route = $inst->getNamedRoute('furniture-type-list-route');

        $this->assertNotNull($route);
        $this->assertEquals('/api/furniture-type/list', $route->getPath());
        $this->assertEquals('GET', $route->getMethod());
    }
}