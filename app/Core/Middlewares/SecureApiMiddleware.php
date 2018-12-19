<?php
/**
 * Created by PhpStorm.
 * User: alberto
 * Date: 3/09/18
 * Time: 04:23 PM
 */

namespace App\Core\Middlewares;

use App\Exceptions\ApiSecurityException;
use App\Utils\RequestUtils;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

/**
 * Class SecureApiMiddleware
 * @package App\Core\Middlewares
 */
class SecureApiMiddleware
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
     * @param ServerRequestInterface $request
     * @param RequestHandlerInterface $handler
     * @return mixed
     * @throws ApiSecurityException
     */
    public function __invoke(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        $jwt = RequestUtils::getJwtTokenFromAuthorizationHeader($request);

        if (!$jwt) {
            throw new ApiSecurityException('Unauthorized request');
        }

        // define authorization process (token based or preferred)
        $valid = true;
        if (!$valid) {
            throw new ApiSecurityException('Invalid token');
        }

        // set authentication result data, or jwt specific data
        $authData = [];
        $request = $request->withAttribute('authData', $authData);

        return $handler->handle($request);
    }
}