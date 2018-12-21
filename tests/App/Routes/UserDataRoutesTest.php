<?php
/**
 * Created by IntelliJ IDEA.
 * User: alberto
 * Date: 21/12/18
 * Time: 02:45 PM
 */

namespace Tests\App\Routes;

use App\Core\AppContainer;
use League\Route\Router;
use PHPUnit\Framework\TestCase;
use Tests\TestUtils;

/**
 * Class UserDataRoutesTest
 * @package Tests\App\Routes
 */
class UserDataRoutesTest extends TestCase
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

        $route = $inst->getNamedRoute('user-data-route');

        $this->assertNotNull($route);
        $this->assertEquals('/api/user/{regId:regId}/data', $route->getPath());
        $this->assertEquals('GET', $route->getMethod());
    }
}