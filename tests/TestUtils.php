<?php
/**
 * Created by IntelliJ IDEA.
 * User: alberto
 * Date: 26/11/18
 * Time: 03:17 PM
 */

namespace Tests;


use App\Consts\Http;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\ResponseInterface;
use Zend\Diactoros\ServerRequestFactory;

/**
 * Class TestUtils
 * @package Tests
 */
class TestUtils
{
    public static function initConstBaseDir()
    {
        if (!defined("BASE_DIR")) {
            define("BASE_DIR", \realpath(__DIR__ . "/../"));
        }
    }

    public static function initConstTesting()
    {
        if (!defined("TESTING")) {
            define("TESTING", true);
        }
    }

    public static function initConsts()
    {
        self::initConstBaseDir();
        self::initConstTesting();
    }

    /**
     * @param $method
     * @param $uri
     * @param array $query
     * @param array $body
     * @return \Zend\Diactoros\ServerRequest
     */
    public static function makeServerRequestMock($method, $uri, $query = [], $body = [])
    {
        $server = [
            "SERVER_SOFTWARE" => "PHP 7.2.7-0ubuntu0.18.04.2 Development Server",
            "SERVER_PROTOCOL" => "HTTP/1.1",
            "HTTP_CONNECTION" => "Keep-Alive",
            "HTTP_ACCEPT_ENCODING" => "gzip,deflate",
        ];

        $server['REQUEST_METHOD'] = $method;
        $server['REQUEST_URI'] = $uri;

        return ServerRequestFactory::fromGlobals($server, $query, $body);
    }

    /**
     * @param TestCase $testInst
     * @param ResponseInterface $response
     */
    public static function runDefaultJsonViewResponseTests(TestCase $testInst, ResponseInterface $response, int $wantedStatusCode = Http::STATUS_CODE_HTTP_OK)
    {
        $testInst->assertNotNull($response);
        $testInst->assertInstanceOf(ResponseInterface::class, $response);

        $testInst->assertTrue($response->hasHeader(Http::HEADER_CONTENT_TYPE), 'The response does not have the CONTENT_TYPE header');

        $contentType = $response->getHeaderLine(Http::HEADER_CONTENT_TYPE);
        $testInst->assertEquals($contentType, Http::CONTENT_TYPE_APPLICATION_JSON_UTF8, 'The response CONTENT_TYPE header is not JSON');

        $testInst->assertEquals($wantedStatusCode, $response->getStatusCode());

        $body = (string)$response->getBody();
        $testInst->assertNotNull($body);

        $arrayBody = \json_decode($body, JSON_OBJECT_AS_ARRAY);
        $testInst->assertNotNull($arrayBody);
    }

    /**
     * @param TestCase $testInst
     * @param ResponseInterface $response
     */
    public static function runDefaulImageJpegResponseTests(TestCase $testInst, ResponseInterface $response, int $wantedStatusCode = Http::STATUS_CODE_HTTP_OK)
    {
        $testInst->assertNotNull($response);
        $testInst->assertInstanceOf(ResponseInterface::class, $response);

        $testInst->assertTrue($response->hasHeader(Http::HEADER_CONTENT_TYPE), 'The response does not have the CONTENT_TYPE header');

        $contentType = $response->getHeaderLine(Http::HEADER_CONTENT_TYPE);
        $testInst->assertEquals($contentType, Http::CONTENT_TYPE_IMAGE_JPEG, 'The response CONTENT_TYPE header is not JPEG');

        $testInst->assertEquals($wantedStatusCode, $response->getStatusCode());

        $body = (string)$response->getBody();
        $testInst->assertNotNull($body);
    }

    public static function deleteDir($dirPath) {
        if (!\is_dir($dirPath)) {
            throw new InvalidArgumentException("$dirPath must be a directory");
        }

        if (\substr($dirPath, \strlen($dirPath) - 1, 1) != '/') {
            $dirPath .= '/';
        }

        $files = \glob($dirPath . '*', GLOB_MARK);
        foreach ($files as $file) {
            if (\is_dir($file)) {
                self::deleteDir($file);
            } else {
                \unlink($file);
            }
        }

        \rmdir($dirPath);
    }
}