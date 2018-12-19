<?php
/**
 * Created by IntelliJ IDEA.
 * User: alberto
 * Date: 11/12/18
 * Time: 01:03 PM
 */

namespace Tests\App\Utils;

use App\Utils\SecurityUtils;
use PHPUnit\Framework\TestCase;

/**
 * Class SecurityUtilsTest
 * @package Tests\App\Utils
 */
class SecurityUtilsTest extends TestCase
{
    public function testCorrectlyHashAndVerifyPassword()
    {
        $pswd = 'test';
        $seed = '1';

        $securedPswd = SecurityUtils::generateSecurePswd($pswd, $seed);

        $this->assertNotNull($securedPswd);

        $verifyResult = SecurityUtils::verifySecurePaswFromHash($pswd, $seed, $securedPswd);

        $this->assertNotNull($verifyResult);
        $this->assertTrue($verifyResult);
    }

    public function testCorrectlyHashAndFailVerificationPassword()
    {
        $pswd = 'test';
        $seed = '1';

        $securedPswd = SecurityUtils::generateSecurePswd($pswd, $seed);

        $this->assertNotNull($securedPswd);

        $badPswd = 'testt';
        $verifyResult = SecurityUtils::verifySecurePaswFromHash($badPswd, $seed, $securedPswd);

        $this->assertNotNull($verifyResult);
        $this->assertFalse($verifyResult);
    }
}