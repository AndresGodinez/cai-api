<?php
/**
 * Created by PhpStorm.
 * User: alberto
 * Date: 3/09/18
 * Time: 04:23 PM
 */

namespace App\Core\Middlewares;

use App\Exceptions\ViewSecurityException;
use App\Utils\SecurityUtils;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;

/**
 * Class SecureApiQueryParamMiddleware
 * @package App\Core\Middlewares
 */
class SecureApiQueryParamMiddleware implements MiddlewareInterface
{
    /** @var array $config */
    protected $config = null;

    /**
     * SecureApiQueryParamMiddleware constructor.
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
     */
    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        $queryParams = $request->getQueryParams();

        if (!$queryParams) {
            $response = \App\Factories\ResponseFactory::buildUnauthorizedJsonResponse();
            $response->getBody()->write(\json_encode(['msg' => 'Unauthorized request 1']));
            return $response;
        }

        $encJwt = $queryParams['a'] ?? false;
        $jwt = \base64_decode($encJwt);

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