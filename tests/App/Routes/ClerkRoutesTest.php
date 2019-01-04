<?php
/**
 * Created by IntelliJ IDEA.
 * User: alberto
 * Date: 4/01/19
 * Time: 11:40 AM
 */

namespace Tests\App\Routes;

use App\Core\AppContainer;
use League\Route\Router;
use PHPUnit\Framework\TestCase;
use Tests\TestUtils;

/**
 * Class ClerkRoutesTest
 * @package Tests\App\Routes
 */
class ClerkRoutesTest extends TestCase
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

        $route = $inst->getNamedRoute('clerk-capture-statistics-route');

        $this->assertNotNull($route);
        $this->assertEquals('/api/clerk/{regId:regId}/capture-statistics', $route->getPath());
        $this->assertEquals('GET', $route->getMethod());
    }
}