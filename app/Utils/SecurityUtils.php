<?php
/**
 * Created by IntelliJ IDEA.
 * User: alberto
 * Date: 11/12/18
 * Time: 01:00 PM
 */

namespace App\Utils;

/**
 * Class SecurityUtils
 * @package App\Utils
 */
class SecurityUtils
{
    /**
     * @param string $val Password string
     * @param string $seed Seed to secure the password
     * @return bool|string
     */
    public static function generateSecurePswd(string $val, string $seed)
    {
        return \password_hash($val . '_' . $seed, \PASSWORD_BCRYPT);
    }

    /**
     * @param string $val Password string
     * @param string $seed Seed to secure the password
     * @param string $hash Hash stored in DB
     * @return bool
     */
    public static function verifySecurePaswFromHash(string $val, string $seed, $hash)
    {
        return \password_verify($val . '_' . $seed, $hash);
    }
}