<?php
/**
 * Created by IntelliJ IDEA.
 * User: alberto
 * Date: 11/12/18
 * Time: 01:00 PM
 */

namespace App\Utils;

use Firebase\JWT\JWT;
use Firebase\JWT\SignatureInvalidException;

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

    public static function encodeDataToJwt(string $secret, array $data)
    {
        return JWT::encode($data, $secret);
    }

    public static function decodeJwtData(string $secret, string $jwt)
    {
        return JWT::decode($jwt, $secret, array("HS256"));
    }

    public static function validateJwt(string $secret, string $jwt)
    {
        try {
            return !!self::decodeJwtData($secret, $jwt);
        } catch (SignatureInvalidException $e) {
        } catch (\UnexpectedValueException $e) {
        }

        return false;
    }
}