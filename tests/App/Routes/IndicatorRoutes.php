<?php
/**
 * Created by IntelliJ IDEA.
 * User: alberto
 * Date: 4/01/19
 * Time: 10:15 AM
 */

namespace Tests\App\Routes;

use App\Core\AppContainer;
use League\Route\Router;
use PHPUnit\Framework\TestCase;
use Tests\TestUtils;

/**
 * Class IndicatorRoutes
 * @package Tests\App\Routes
 */
class IndicatorRoutes extends TestCase
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

        $route = $inst->getNamedRoute('indicator-progress-perc-by-clerk-route');

        $this->assertNotNull($route);
        $this->assertEquals('/api/indicator/progress-perc-by-clerk', $route->getPath());
        $this->assertEquals('GET', $route->getMethod());
    }
}