<?php
/**
 * Created by IntelliJ IDEA.
 * User: alberto
 * Date: 27/12/18
 * Time: 06:48 PM
 */

namespace Tests\App\Routes;

use App\Core\AppContainer;
use League\Route\Router;
use PHPUnit\Framework\TestCase;
use Tests\TestUtils;

/**
 * Class InventoryEvidencePhotoRoutesTest
 * @package Tests\App\Routes
 */
class InventoryEvidencePhotoRoutesTest extends TestCase
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

        $route = $inst->getNamedRoute('inventory-evidence-photo-read-photo-content-route');

        $this->assertNotNull($route);
        $this->assertEquals('/api/inventory-evidence-photo/{regId:regId}', $route->getPath());
        $this->assertEquals('GET', $route->getMethod());
    }
}