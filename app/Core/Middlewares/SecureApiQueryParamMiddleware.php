<?php
/**
 * Created by PhpStorm.
 * User: alberto
 * Date: 3/09/18
 * Time: 04:23 PM
 */

namespace App\Core\Middlewares;

use App\Exceptions\ViewSecurityException;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

/**
 * Class SecureApiQueryParamMiddleware
 * @package App\Core\Middlewares
 */
class SecureApiQueryParamMiddleware
{
    /**
     * @param ServerRequestInterface $request
     * @param RequestHandlerInterface $handler
     * @return mixed
     * @throws ViewSecurityException
     */
    public function __invoke(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        $queryParams = $request->getQueryParams();

        if (!$queryParams) {
            throw new ViewSecurityException('Unauthorized request', 401);
        }

        $encJwt = $queryParams['a'] ?? false;

        if (!$encJwt) {
            throw new ViewSecurityException('Unauthorized request', 401);
        }

        // todo: decrypt and validate token

        return $handler->handle($request);
    }
}