<?php
/**
 * Created by IntelliJ IDEA.
 * User: alberto
 * Date: 27/12/18
 * Time: 11:14 AM
 */

namespace Tests\App\Routes;

use App\Core\AppContainer;
use League\Route\Router;
use PHPUnit\Framework\TestCase;
use Tests\TestUtils;

/**
 * Class InventoryEvidenceRoutesTest
 * @package Tests\App\Routes
 */
class InventoryEvidenceRoutesTest extends TestCase
{
    public static function setUpBeforeClass()
    {
        TestUtils::initConsts();
    }

    public function testAppRouterContainsAuthRoute()
    {
        $container = AppContainer::make(BASE_DIR);

        /** @var Router $inst */
        $inst = $container->get('router');

        $route = $inst->getNamedRoute('inventory-evidence-create-route');

        $this->assertNotNull($route);
        $this->assertEquals('/api/inventory-evidence', $route->getPath());
        $this->assertEquals('POST', $route->getMethod());
    }

    public function testAppRouterContainsReadRegistersRoute()
    {
        $container = AppContainer::make(BASE_DIR);

        /** @var Router $inst */
        $inst = $container->get('router');

        $route = $inst->getNamedRoute('inventory-evidence-read-registers-route');

        $this->assertNotNull($route);
        $this->assertEquals('/api/inventory-evidence', $route->getPath());
        $this->assertEquals('GET', $route->getMethod());
    }

    public function testAppRouterContainsReadRegistersCountRoute()
    {
        $container = AppContainer::make(BASE_DIR);

        /** @var Router $inst */
        $inst = $container->get('router');

        $route = $inst->getNamedRoute('inventory-evidence-read-registers-count-route');

        $this->assertNotNull($route);
        $this->assertEquals('/api/inventory-evidence/count', $route->getPath());
        $this->assertEquals('GET', $route->getMethod());
    }
}