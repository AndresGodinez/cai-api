<?php
/**
 * Created by IntelliJ IDEA.
 * User: alberto
 * Date: 29/11/18
 * Time: 02:42 PM
 */

namespace App\Factories;

use App\Core\Config;
use App\Exceptions\InternalException;

/**
 * Class ConnectionFactory
 * @package App\Factories
 */
class ConnectionFactory
{
    /**
     * @param Config $config
     * @return \PDO
     * @throws InternalException
     */
    public static function buildFromConfig(Config $config)
    {
        $driver = $config->get('PDO_DRIVER', '');
        $host = $config->get('DOCTRINE_HOST', '');
        $user = $config->get('DOCTRINE_USERNAME', false);
        $password = $config->get('DOCTRINE_PSWD', false);
        $charset = $config->get('DOCTRINE_CHARSET', 'utf8');
        $db = $config->get('DOCTRINE_DB', '');

        $dsn = "$driver:dbname=$db;host=$host;charset=$charset";
        try {
            $pdo = new \PDO($dsn, $user, $password);
        } catch (\PDOException $ex) {
            \error_log($ex->getMessage());
            throw new InternalException('Error on connection instantiation');
        }

        return $pdo;
    }

    /**
     * @param Config $config
     * @return \PDO
     * @throws InternalException
     */
    public static function buildTestInstanceFromConfig(Config $config)
    {
        $driver = $config->get('PDO_DRIVER', '');
        $host = $config->get('DOCTRINE_TEST_HOST', '');
        $user = $config->get('DOCTRINE_TEST_USERNAME', false);
        $password = $config->get('DOCTRINE_TEST_PSWD', false);
        $charset = $config->get('DOCTRINE_TEST_CHARSET', 'utf8');
        $db = $config->get('DOCTRINE_TEST_DB', '');

        $dsn = "$driver:dbname=$db;host=$host;charset=$charset";
        try {
            $pdo = new \PDO($dsn, $user, $password);
        } catch (\PDOException $ex) {
            \error_log($ex->getMessage());
            throw new InternalException('Error on connection instantiation');
        }

        return $pdo;
    }
}