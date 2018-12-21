<?php
/**
 * Created by PhpStorm.
 * User: alberto
 * Date: 3/09/18
 * Time: 04:23 PM
 */

namespace App\Core\Middlewares;

use App\Consts\Http;
use App\Exceptions\ApiSecurityException;
use App\Utils\RequestUtils;
use App\Utils\SecurityUtils;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;

/**
 * Class SecureApiMiddleware
 * @package App\Core\Middlewares
 */
class SecureApiMiddleware implements MiddlewareInterface
{
    /** @var array $config */
    protected $config = null;

    /**
     * SecureApiMiddleware constructor.
     * @param array $config
     */
    public function __construct(array $config)
    {
        $this->config = $config;
    }

    /**
     * Process an incoming server request.
     *
     * Processes an incoming server request in order to produce a response.
     * If unable to produce the response itself, it may delegate to the provided
     * request handler to do so.
     * @throws ApiSecurityException
     */
    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        if (!$request->hasHeader(Http::HEADER_AUTHORIZATION)) {
            $response = \App\Factories\ResponseFactory::buildUnauthorizedJsonResponse();
            $response->getBody()->write(\json_encode(['msg' => 'Unauthorized request 1']));
            return $response;
        }

        $authorizationHeader = $request->getHeaderLine(Http::HEADER_AUTHORIZATION);

        if (!$authorizationHeader) {
            $response = \App\Factories\ResponseFactory::buildUnauthorizedJsonResponse();
            $response->getBody()->write(\json_encode(['msg' => 'Unauthorized request 2']));
            return $response;
        }

        list($jwt) = \sscanf($authorizationHeader, 'Bearer %s');

        if (!$jwt) {
            $response = \App\Factories\ResponseFactory::buildUnauthorizedJsonResponse();
            $response->getBody()->write(\json_encode(['msg' => 'Unauthorized request 3']));
            return $response;
        }

        // define authorization process (token based or preferred)
        $secret = $this->config['APP_JWT_SECRET'] ?? '';
        if (!SecurityUtils::validateJwt($secret, $jwt)) {
            $response = \App\Factories\ResponseFactory::buildUnauthorizedJsonResponse();
            $response->getBody()->write(\json_encode(['msg' => 'Invalid token']));
            return $response;
        }

        // set authentication result data, or jwt specific data
        $authData = SecurityUtils::decodeJwtData($secret, $jwt);

        $request = $request->withAttribute('authData', (array)$authData);

        return $handler->handle($request);
    }
}