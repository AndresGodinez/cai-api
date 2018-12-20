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

    public function testEncodeDataToJwtSuccessfully()
    {
        $secret = 'test';

        $data = [
            "iat" => \time(),
            "nbf" => \time(),
            "sub" => \uniqid(),
            'userId' => 1,
            'agentId' => 1,
            'name' => 'test',
        ];

        $jwt = SecurityUtils::encodeDataToJwt($secret, $data);

        $this->assertNotNull($jwt);

        $re = '/^([a-zA-Z0-9_=]+)\.([a-zA-Z0-9_=]+)\.([a-zA-Z0-9_\-\+\/=]*)$/m';
        $this->assertRegExp($re, $jwt);

        $this->assertTrue(SecurityUtils::validateJwt($secret, $jwt));
    }

    public function testValidateJwtSuccessfully()
    {
        $secret = 'test';
        $jwt = 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpYXQiOjE1NDUzNDUyNDQsIm5iZiI6MTU0NTM0NTI0NCwic3ViIjoiNWMxYzE4ZGMzYzA3YyIsInVzZXJJZCI6MSwiYWdlbnRJZCI6MSwibmFtZSI6InRlc3QifQ.pXrC84Zp8SuzuhdNQTrxof-nmsluJkmhfnVxwBc-Fz4';

        $this->assertTrue(SecurityUtils::validateJwt($secret, $jwt));
    }

    public function testErrorValidateJwt()
    {
        $secret = 'test';
        $jwt = 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpYXQiOjE1NDUzNDUyNDQsIm5iZiI6MTU0NTM0NTI0NCwic3ViIjoiNWMxYzE4ZGMzYzA3YyIsInVzZXJJZCI6MSwiYWdlbnRJZCI6MSwibmFtZSI6InRlc3QifQ.pXrC84Zp8SuzuhdNQTrxof-nmsluJkmhfnVxwBc-Fz';

        $this->assertFalse(SecurityUtils::validateJwt($secret, $jwt));
    }

    public function testDecodeJwtData()
    {
        $secret = 'test';
        $jwt = 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpYXQiOjE1NDUzNDUyNDQsIm5iZiI6MTU0NTM0NTI0NCwic3ViIjoiNWMxYzE4ZGMzYzA3YyIsInVzZXJJZCI6MSwiYWdlbnRJZCI6MSwibmFtZSI6InRlc3QifQ.pXrC84Zp8SuzuhdNQTrxof-nmsluJkmhfnVxwBc-Fz4';

        $data = SecurityUtils::decodeJwtData($secret, $jwt);

        $this->assertNotNull($data);
        $this->assertObjectHasAttribute('iat', $data);
        $this->assertObjectHasAttribute('nbf', $data);
        $this->assertObjectHasAttribute('sub', $data);
        $this->assertObjectHasAttribute('userId', $data);
        $this->assertObjectHasAttribute('agentId', $data);
        $this->assertObjectHasAttribute('name', $data);
    }
}