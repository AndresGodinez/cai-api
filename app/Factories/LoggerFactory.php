<?php
/**
 * Created by IntelliJ IDEA.
 * User: alberto
 * Date: 29/11/18
 * Time: 12:12 PM
 */

namespace App\Factories;

use App\Core\Config;
use Monolog\Formatter\LineFormatter;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;

/**
 * Class LoggerFactory
 * @package App\Factories
 */
class LoggerFactory
{
    /**
     * @param Config $config
     * @return Logger
     * @throws \App\Exceptions\InternalException
     * @throws \Exception
     */
    public static function buildDebugLoggerFromConfig(Config $config)
    {
        $logsBaseDir = $config->get('APP_LOGS_BASE_DIR', '');

        $logger = new Logger('app-debug-logger');

        $stream = $logsBaseDir . '/debug.log';
        $fileHandler = new StreamHandler($stream, Logger::DEBUG);
        $fileHandler->setFormatter(new LineFormatter());

        $logger->pushHandler($fileHandler);

        return $logger;
    }

    /**
     * @param Config $config
     * @return Logger
     * @throws \App\Exceptions\InternalException
     * @throws \Exception
     */
    public static function buildErrorLoggerFromConfig(Config $config)
    {
        $logsBaseDir = $config->get('APP_LOGS_BASE_DIR', '');

        $logger = new Logger('app-error-logger');

        $stream = $logsBaseDir . '/error.log';
        $fileHandler = new StreamHandler($stream, Logger::ERROR);
        $fileHandler->setFormatter(new LineFormatter());

        $logger->pushHandler($fileHandler);

        return $logger;
    }
}