<?php
/**
 * Created by IntelliJ IDEA.
 * User: alberto
 * Date: 28/11/18
 * Time: 02:40 PM
 */

namespace App\Utils;

class SessionUtils
{
    const CONFIG_SESSION_NAME_KEY = 'APP_SESSION_NAME';

    const INTERNAL_SESSION_NAME = "APP_INTERNAL";

    /**
     * @param string $base
     * @return string
     */
    public static function generateSessionName(string $base)
    {
        $sessionName = \md5($base);
        return $sessionName;
    }

    /**
     * @param array $config
     * @return string
     */
    public static function generateSessionNameFromConfig(array $config)
    {
        $configSessionName = $config[self::CONFIG_SESSION_NAME_KEY];
        return self::generateSessionName($configSessionName);
    }

    /**
     * @param array $config
     * @return string
     */
    public static function setSessionName(array $config)
    {
        $sessionName = self::generateSessionNameFromConfig($config);
        \session_name($sessionName);

        return $sessionName;
    }

    /**
     * @param array $config
     */
    public static function initSessionFromConfig(array $config)
    {
        if (\defined('TESTING') && !!TESTING) {
            return;
        }

        if (self::isCustomSessionCurrentlyRunning()) {
            return;
        }

        $sessionName = self::setSessionName($config);

        \session_start();
    }

    /**
     * @return bool
     */
    public static function writeAndClose()
    {
        if (\defined('TESTING') && !!TESTING) {
            return true;
        }

        \session_write_close();

        return true;
    }

    public static function deleteSessionData()
    {
        if (isset($_SESSION)) {
            $_SESSION = array();
        }
    }

    public static function isCustomSessionCurrentlyRunning()
    {
        return \session_status() !== PHP_SESSION_NONE;
    }
}