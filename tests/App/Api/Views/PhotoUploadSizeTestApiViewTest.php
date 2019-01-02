<?php
/**
 * Created by IntelliJ IDEA.
 * User: alberto
 * Date: 2/01/19
 * Time: 11:12 AM
 */

namespace Tests\App\Api\Views;

use App\Consts\Http;
use App\Core\AppContainer;
use League\Route\Router;
use PHPUnit\DbUnit\DataSet\IDataSet;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface;
use Tests\ConfigurableConnectionTestTrait;
use Tests\DbUnitTestCase;
use Tests\TestUtils;
use Zend\Diactoros\Stream;
use Zend\Diactoros\UploadedFile;

/**
 * Class PhotoUploadSizeTestApiViewTest
 * @package Tests\App\Api\Views
 */
class PhotoUploadSizeTestApiViewTest extends DbUnitTestCase
{
    use ConfigurableConnectionTestTrait;

    /** @var ContainerInterface */
    private static $container;

    public static function setUpBeforeClass()
    {
        TestUtils::initConsts();

        self::$container = AppContainer::make(BASE_DIR);
    }

    public function testSuccessfullyRequestWithLowestPhotoSizes()
    {
        $jwt = 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpYXQiOjE1NDU0Mjg1ODksIm5iZiI6MTU0NTQyODU4OSwic3ViIjoiNWMxZDVlNmQ4OThlMiIsInVzZXJJZCI6MSwibmFtZSI6IkFkbWluaXN0cmFkb3IifQ.cAIuyq-vljpo_mdwD0Z83g7iYGEEW-WvglyH0qpAZxU';

        /** @var Router $router */
        $router = self::$container->get('router');

        $photo1Stream = new Stream(BASE_DIR . "/tests/files-resources/test-size-small-1.jpg", 'r');
        $photo2Stream = new Stream(BASE_DIR . "/tests/files-resources/test-size-small-1.jpg", 'r');
        $photo3Stream = new Stream(BASE_DIR . "/tests/files-resources/test-size-small-1.jpg", 'r');
        $photo4Stream = new Stream(BASE_DIR . "/tests/files-resources/test-size-small-2.jpg", 'r');
        $photo5Stream = new Stream(BASE_DIR . "/tests/files-resources/test-size-small-2.jpg", 'r');

        $photo1 = new UploadedFile($photo1Stream, $photo1Stream->getSize(), 0, "photo-test-001.jpg", "image/jpeg");
        $photo2 = new UploadedFile($photo2Stream, $photo2Stream->getSize(), 0, "photo-test-002.jpg", "image/jpeg");
        $photo3 = new UploadedFile($photo3Stream, $photo3Stream->getSize(), 0, "photo-test-003.jpg", "image/jpeg");
        $photo4 = new UploadedFile($photo4Stream, $photo4Stream->getSize(), 0, "photo-test-004.jpg", "image/jpeg");
        $photo5 = new UploadedFile($photo5Stream, $photo5Stream->getSize(), 0, "photo-test-005.jpg", "image/jpeg");

        $request = TestUtils::makeServerRequestMock('POST', '/api/photo-upload-size-test');
        $request = $request->withHeader(Http::HEADER_AUTHORIZATION, 'Bearer ' . $jwt);
        $request = $request->withUploadedFiles([
            'photo-1' => $photo1,
            'photo-2' => $photo2,
            'photo-3' => $photo3,
            'photo-4' => $photo4,
            'photo-5' => $photo5,
        ]);

        /** @var ResponseInterface $response */
        $response = $router->dispatch($request);

        TestUtils::runDefaultJsonViewResponseTests($this, $response);

        $body = (string)$response->getBody();
        $arrayBody = \json_decode($body, JSON_OBJECT_AS_ARRAY);

        $this->assertArrayHasKey('msg', $arrayBody);
        $this->assertEquals('OK', $arrayBody['msg']);
    }

    public function testSuccessfullyRequestWithMediumPhotoSizes()
    {
        $jwt = 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpYXQiOjE1NDU0Mjg1ODksIm5iZiI6MTU0NTQyODU4OSwic3ViIjoiNWMxZDVlNmQ4OThlMiIsInVzZXJJZCI6MSwibmFtZSI6IkFkbWluaXN0cmFkb3IifQ.cAIuyq-vljpo_mdwD0Z83g7iYGEEW-WvglyH0qpAZxU';

        /** @var Router $router */
        $router = self::$container->get('router');

        $photo1Stream = new Stream(BASE_DIR . "/tests/files-resources/test-size-medium-1.jpg", 'r');
        $photo2Stream = new Stream(BASE_DIR . "/tests/files-resources/test-size-medium-1.jpg", 'r');

        $photo1 = new UploadedFile($photo1Stream, $photo1Stream->getSize(), 0, "photo-test-001.jpg", "image/jpeg");
        $photo2 = new UploadedFile($photo2Stream, $photo2Stream->getSize(), 0, "photo-test-002.jpg", "image/jpeg");

        $request = TestUtils::makeServerRequestMock('POST', '/api/photo-upload-size-test');
        $request = $request->withHeader(Http::HEADER_AUTHORIZATION, 'Bearer ' . $jwt);
        $request = $request->withUploadedFiles([
            'photo-1' => $photo1,
            'photo-2' => $photo2,
        ]);

        /** @var ResponseInterface $response */
        $response = $router->dispatch($request);

        TestUtils::runDefaultJsonViewResponseTests($this, $response);

        $body = (string)$response->getBody();
        $arrayBody = \json_decode($body, JSON_OBJECT_AS_ARRAY);

        $this->assertArrayHasKey('msg', $arrayBody);
        $this->assertEquals('OK', $arrayBody['msg']);
    }

    public function testBadRequestWithMixedMediumAndSmallSizes()
    {
        $jwt = 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpYXQiOjE1NDU0Mjg1ODksIm5iZiI6MTU0NTQyODU4OSwic3ViIjoiNWMxZDVlNmQ4OThlMiIsInVzZXJJZCI6MSwibmFtZSI6IkFkbWluaXN0cmFkb3IifQ.cAIuyq-vljpo_mdwD0Z83g7iYGEEW-WvglyH0qpAZxU';

        /** @var Router $router */
        $router = self::$container->get('router');

        $photo1Stream = new Stream(BASE_DIR . "/tests/files-resources/test-size-small-1.jpg", 'r');
        $photo2Stream = new Stream(BASE_DIR . "/tests/files-resources/test-size-big-1.jpg", 'r');

        $photo1 = new UploadedFile($photo1Stream, $photo1Stream->getSize(), 0, "photo-test-001.jpg", "image/jpeg");
        $photo2 = new UploadedFile($photo2Stream, $photo2Stream->getSize(), 0, "photo-test-002.png", "image/png");

        $request = TestUtils::makeServerRequestMock('POST', '/api/photo-upload-size-test');
        $request = $request->withHeader(Http::HEADER_AUTHORIZATION, 'Bearer ' . $jwt);
        $request = $request->withUploadedFiles([
            'photo-1' => $photo1,
            'photo-2' => $photo2,
        ]);

        /** @var ResponseInterface $response */
        $response = $router->dispatch($request);

        TestUtils::runDefaultJsonViewResponseTests($this, $response, Http::STATUS_CODE_HTTP_BAD_REQUEST);

        $body = (string)$response->getBody();
        $arrayBody = \json_decode($body, JSON_OBJECT_AS_ARRAY);

        $this->assertArrayHasKey('msg', $arrayBody);
        $this->assertStringContainsStringIgnoringCase('Una de las fotos es demasiado grande para procesarse. Por favor, suba imágenes que no sobrepasen los 5 MB.', $arrayBody['msg']);
    }

    public function testBadRequestWithBigPhotoSize1()
    {
        $jwt = 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpYXQiOjE1NDU0Mjg1ODksIm5iZiI6MTU0NTQyODU4OSwic3ViIjoiNWMxZDVlNmQ4OThlMiIsInVzZXJJZCI6MSwibmFtZSI6IkFkbWluaXN0cmFkb3IifQ.cAIuyq-vljpo_mdwD0Z83g7iYGEEW-WvglyH0qpAZxU';

        /** @var Router $router */
        $router = self::$container->get('router');

        $photo1Stream = new Stream(BASE_DIR . "/tests/files-resources/test-size-big-1.jpg", 'r');

        $photo1 = new UploadedFile($photo1Stream, $photo1Stream->getSize(), 0, "photo-test-001.jpg", "image/jpeg");

        $request = TestUtils::makeServerRequestMock('POST', '/api/photo-upload-size-test');
        $request = $request->withHeader(Http::HEADER_AUTHORIZATION, 'Bearer ' . $jwt);
        $request = $request->withUploadedFiles([
            'photo-1' => $photo1,
        ]);

        /** @var ResponseInterface $response */
        $response = $router->dispatch($request);

        TestUtils::runDefaultJsonViewResponseTests($this, $response, Http::STATUS_CODE_HTTP_BAD_REQUEST);

        $body = (string)$response->getBody();
        $arrayBody = \json_decode($body, JSON_OBJECT_AS_ARRAY);

        $this->assertArrayHasKey('msg', $arrayBody);
        $this->assertStringContainsStringIgnoringCase('Una de las fotos es demasiado grande para procesarse. Por favor, suba imágenes que no sobrepasen los 5 MB.', $arrayBody['msg']);
    }

    public function testBadRequestWithBigPhotoSize2()
    {
        $jwt = 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpYXQiOjE1NDU0Mjg1ODksIm5iZiI6MTU0NTQyODU4OSwic3ViIjoiNWMxZDVlNmQ4OThlMiIsInVzZXJJZCI6MSwibmFtZSI6IkFkbWluaXN0cmFkb3IifQ.cAIuyq-vljpo_mdwD0Z83g7iYGEEW-WvglyH0qpAZxU';

        /** @var Router $router */
        $router = self::$container->get('router');

        $photo1Stream = new Stream(BASE_DIR . "/tests/files-resources/test-size-big-2.jpg", 'r');

        $photo1 = new UploadedFile($photo1Stream, $photo1Stream->getSize(), 0, "photo-test-001.jpg", "image/jpeg");

        $request = TestUtils::makeServerRequestMock('POST', '/api/photo-upload-size-test');
        $request = $request->withHeader(Http::HEADER_AUTHORIZATION, 'Bearer ' . $jwt);
        $request = $request->withUploadedFiles([
            'photo-1' => $photo1,
        ]);

        /** @var ResponseInterface $response */
        $response = $router->dispatch($request);

        TestUtils::runDefaultJsonViewResponseTests($this, $response, Http::STATUS_CODE_HTTP_BAD_REQUEST);

        $body = (string)$response->getBody();
        $arrayBody = \json_decode($body, JSON_OBJECT_AS_ARRAY);

        $this->assertArrayHasKey('msg', $arrayBody);
        $this->assertStringContainsStringIgnoringCase('Una de las fotos es demasiado grande para procesarse. Por favor, suba imágenes que no sobrepasen los 5 MB.', $arrayBody['msg']);
    }

    public function testBadRequestPhotosExceedsRequestSize()
    {
        $jwt = 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpYXQiOjE1NDU0Mjg1ODksIm5iZiI6MTU0NTQyODU4OSwic3ViIjoiNWMxZDVlNmQ4OThlMiIsInVzZXJJZCI6MSwibmFtZSI6IkFkbWluaXN0cmFkb3IifQ.cAIuyq-vljpo_mdwD0Z83g7iYGEEW-WvglyH0qpAZxU';

        /** @var Router $router */
        $router = self::$container->get('router');

        $photo1Stream = new Stream(BASE_DIR . "/tests/files-resources/test-size-small-1.jpg", 'r');
        $photo2Stream = new Stream(BASE_DIR . "/tests/files-resources/test-size-small-1.jpg", 'r');
        $photo3Stream = new Stream(BASE_DIR . "/tests/files-resources/test-size-small-2.jpg", 'r');
        $photo4Stream = new Stream(BASE_DIR . "/tests/files-resources/test-size-small-2.jpg", 'r');
        $photo5Stream = new Stream(BASE_DIR . "/tests/files-resources/test-size-small-2.jpg", 'r');

        $photo1 = new UploadedFile($photo1Stream, $photo1Stream->getSize(), 0, "photo-test-001.jpg", "image/jpeg");
        $photo2 = new UploadedFile($photo2Stream, $photo2Stream->getSize(), 0, "photo-test-002.jpg", "image/jpeg");
        $photo3 = new UploadedFile($photo3Stream, $photo3Stream->getSize(), 0, "photo-test-003.jpg", "image/jpeg");
        $photo4 = new UploadedFile($photo4Stream, $photo4Stream->getSize(), 0, "photo-test-004.jpg", "image/jpeg");
        $photo5 = new UploadedFile($photo5Stream, $photo5Stream->getSize(), 0, "photo-test-005.jpg", "image/jpeg");

        $request = TestUtils::makeServerRequestMock('POST', '/api/photo-upload-size-test');
        $request = $request->withHeader(Http::HEADER_AUTHORIZATION, 'Bearer ' . $jwt);
        $request = $request->withUploadedFiles([
            'photo-1' => $photo1,
            'photo-2' => $photo2,
            'photo-3' => $photo3,
            'photo-4' => $photo4,
            'photo-5' => $photo5,
        ]);

        /** @var ResponseInterface $response */
        $response = $router->dispatch($request);

        TestUtils::runDefaultJsonViewResponseTests($this, $response, Http::STATUS_CODE_HTTP_BAD_REQUEST);

        $body = (string)$response->getBody();
        $arrayBody = \json_decode($body, JSON_OBJECT_AS_ARRAY);

        $this->assertArrayHasKey('msg', $arrayBody);
        $this->assertStringContainsStringIgnoringCase('Las fotos exceden el tamaño máximo de peso que se puede procesar (10 MB)', $arrayBody['msg']);
    }

    /**
     * Returns the test dataset.
     *
     * @return IDataSet
     */
    protected function getDataSet()
    {
        $xmlFile = BASE_DIR . '/tests/dbunit-resources/api-bad-auth-route.xml';
        return $this->createMySQLXMLDataSet($xmlFile);
    }
}