<?php
/**
 * Created by IntelliJ IDEA.
 * User: alberto
 * Date: 29/11/18
 * Time: 01:23 PM
 */

namespace Tests\App\Factories;

use App\Core\AppContainer;
use App\Core\Config;
use App\Factories\LoggerFactory;
use Monolog\Handler\HandlerInterface;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;
use PHPUnit\Framework\TestCase;
use Tests\TestUtils;
use Zend\Diactoros\Stream;

/**
 * Class LoggerFactoryTests
 * @package Tests\App\Factories
 */
class LoggerFactoryTest extends TestCase
{
    public static function setUpBeforeClass()
    {
        TestUtils::initConsts();
    }

    /**
     * @throws \App\Exceptions\InternalException
     */
    public function testCanBuildDebugLoggerFromConfigInstance()
    {
        $container = AppContainer::make(BASE_DIR);

        /** @var Config $inst */
        $config = $container->get('model-config');

        $logger = LoggerFactory::buildDebugLoggerFromConfig($config);

        $this->assertNotNull($logger);
        $this->assertInstanceOf(Logger::class, $logger);
        $this->assertEquals($logger->getName(), 'app-debug-logger');

        $handlers = $logger->getHandlers();

        $this->assertEquals(1, \count($handlers));
        $this->assertInstanceOf(StreamHandler::class, $handlers[0]);

        /** @var StreamHandler $handler */
        $handler = $handlers[0];
        $this->assertEquals(Logger::DEBUG, $handler->getLevel());
    }

    /**
     * @throws \App\Exceptions\InternalException
     */
    public function testCanBuildErrorLoggerFromConfigInstance()
    {
        $container = AppContainer::make(BASE_DIR);

        /** @var Config $inst */
        $config = $container->get('model-config');

        $logger = LoggerFactory::buildErrorLoggerFromConfig($config);

        $this->assertNotNull($logger);
        $this->assertInstanceOf(Logger::class, $logger);
        $this->assertEquals($logger->getName(), 'app-error-logger');

        $handlers = $logger->getHandlers();

        $this->assertEquals(1, \count($handlers));
        $this->assertInstanceOf(StreamHandler::class, $handlers[0]);

        /** @var StreamHandler $handler */
        $handler = $handlers[0];
        $this->assertEquals(Logger::ERROR, $handler->getLevel());
    }
}