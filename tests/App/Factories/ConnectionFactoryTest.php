<?php
/**
 * Created by IntelliJ IDEA.
 * User: alberto
 * Date: 29/11/18
 * Time: 02:51 PM
 */

namespace Tests\App\Factories;

use App\Core\AppContainer;
use App\Core\Config;
use App\Factories\ConnectionFactory;
use PDO;
use PDOException;
use PHPUnit\Framework\TestCase;
use Tests\TestUtils;

/**
 * Class ConnectionFactoryTests
 * @package Tests\App\Factories
 */
class ConnectionFactoryTest extends TestCase
{
    public static function setUpBeforeClass()
    {
        TestUtils::initConsts();
    }

    /**
     * @throws \App\Exceptions\InternalException
     */
    public function testInstanceTestConnectionSuccessfully()
    {
        $container = AppContainer::make(BASE_DIR);

        /** @var Config $inst */
        $config = $container->get('model-config');

        $conn = ConnectionFactory::buildTestInstanceFromConfig($config);

        $this->assertNotNull($conn);
        $this->assertInstanceOf(PDO::class, $conn);
    }
}