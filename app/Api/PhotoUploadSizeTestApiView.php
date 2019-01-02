<?php
/**
 * Created by IntelliJ IDEA.
 * User: alberto
 * Date: 2/01/19
 * Time: 12:57 PM
 */

namespace App\Api;

use App\Core\Config;
use App\Factories\ResponseFactory;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\UploadedFileInterface;

/**
 * Class PhotoUploadSizeTestApiView
 * @package App\Api
 */
class PhotoUploadSizeTestApiView
{
    /** @var Config */
    protected $config;

    public function setConfig(Config $config): void
    {
        $this->config = $config;
    }

    /**
     * @param ServerRequestInterface $request
     * @return ResponseInterface
     * @throws \App\Exceptions\InternalException
     */
    public function __invoke(ServerRequestInterface $request) : ResponseInterface
    {
        $response = ResponseFactory::buildBasicJsonResponse();
        $response->getBody()->write(\json_encode(['msg' => 'OK']));
        return $response;
    }
}