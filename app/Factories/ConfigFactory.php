<?php
/**
 * Created by IntelliJ IDEA.
 * User: alberto
 * Date: 3/10/18
 * Time: 10:22 AM
 */

namespace App\Factories;

use App\Core\Config;
use Dotenv\Dotenv;

/**
 * Class ConfigFactory
 * @package App\Factories
 */
class ConfigFactory
{
    /**
     * @param string $path
     * @return Config
     */
    public static function buildFromPath(string $path)
    {
        $config = new Config();

        $dotenv = new Dotenv($path);
        $dotenv->load();
        $data = $_ENV;

        $config->setData($data);
        return $config;
    }
}