<?php
/**
 * Created by IntelliJ IDEA.
 * User: alberto
 * Date: 26/11/18
 * Time: 04:27 PM
 */

namespace Tests\App\Factories;


use App\Consts\Http;
use App\Factories\ResponseFactory;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\ResponseInterface;


/**
 * Class ResponseFactoryTests
 * @package Tests\App\Factories
 */
class ResponseFactoryTest extends TestCase
{
    /**
     * Tests the static function ResponseFactory::buildBasicJsonResponse that musts return a valid ResponseInterface
     * with default content-type json header
     */
    public function testBuildBasicJsonResponse()
    {

        $r = ResponseFactory::buildBasicJsonResponse();

        $this->assertNotNull($r);
        $this->assertInstanceOf(ResponseInterface::class, $r);

        $this->assertTrue($r->hasHeader(Http::HEADER_CONTENT_TYPE));

        $this->assertEquals(Http::CONTENT_TYPE_APPLICATION_JSON_UTF8, $r->getHeaderLine(Http::HEADER_CONTENT_TYPE));
    }

    /**
     * Tests the static function ResponseFactory::buildBasicBadJsonResponse that musts return a valid ResponseInterface
     * with default content-type json header and a bad_request http status code
     */
    public function testBuildBasicBadJsonResponse()
    {

        $r = ResponseFactory::buildBasicBadJsonResponse();

        $this->assertNotNull($r);
        $this->assertInstanceOf(ResponseInterface::class, $r);

        $this->assertTrue($r->hasHeader(Http::HEADER_CONTENT_TYPE));

        $this->assertEquals(Http::CONTENT_TYPE_APPLICATION_JSON_UTF8, $r->getHeaderLine(Http::HEADER_CONTENT_TYPE));
        $this->assertEquals(Http::STATUS_CODE_HTTP_BAD_REQUEST, $r->getStatusCode());
    }

    /**
     * Tests the static function ResponseFactory::buildUnauthorizedJsonResponse that musts return a valid ResponseInterface
     * with default content-type json header and a unauthorized http status code
     */
    public function testBuildUnauthorizedJsonResponse()
    {

        $r = ResponseFactory::buildUnauthorizedJsonResponse();

        $this->assertNotNull($r);
        $this->assertInstanceOf(ResponseInterface::class, $r);

        $this->assertTrue($r->hasHeader(Http::HEADER_CONTENT_TYPE));

        $this->assertEquals(Http::CONTENT_TYPE_APPLICATION_JSON_UTF8, $r->getHeaderLine(Http::HEADER_CONTENT_TYPE));
        $this->assertEquals(Http::STATUS_CODE_HTTP_UNAUTHORIZED, $r->getStatusCode());
    }
}