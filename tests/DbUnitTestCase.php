<?php
/**
 * Created by IntelliJ IDEA.
 * User: alberto
 * Date: 29/11/18
 * Time: 02:41 PM
 */

namespace Tests;

use App\Core\Config;
use App\Factories\ConnectionFactory;
use PHPUnit\DbUnit\TestCase;

/**
 * Class DbUnitTestCase
 * @package Tests
 */
abstract class DbUnitTestCase extends TestCase
{
    /** @var Config */
    protected $config;

    // only instantiate PHPUnit_Extensions_Database_DB_IDatabaseConnection once per test
    private $conn = null;

    // only instantiate pdo once for test clean-up/fixture load
    static private $pdo = null;

    /**
     * @return mixed
     */
    public function getConfig()
    {
        return $this->config;
    }

    /**
     * @param mixed $config
     */
    public function setConfig($config)
    {
        $this->config = $config;
    }

    /**
     * Returns the test database connection.
     *
     * @return \PHPUnit\DbUnit\Database\Connection
     * @throws \App\Exceptions\InternalException
     */
    protected function getConnection()
    {
        if ($this->conn === null) {
            $db = $this->config->get('DOCTRINE_TEST_DB');

            if (self::$pdo == null) {
                self::$pdo = ConnectionFactory::buildTestInstanceFromConfig($this->config);
            }
            $this->conn = $this->createDefaultDBConnection(self::$pdo, $db);
        }

        return $this->conn;
    }
}