<?php
/**
 * Created by PhpStorm.
 * User: alberto
 * Date: 4/09/18
 * Time: 04:14 PM
 */

namespace App\Core\Middlewares;

use App\Utils\ResponseUtils;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

/**
 * Class CorsApiMiddleware
 * @package App\Core\Middlewares
 */
class CorsApiMiddleware
{
    /**
     * @param ServerRequestInterface $request
     * @param RequestHandlerInterface $handler
     * @return mixed
     */
    public function __invoke(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        ResponseUtils::addCorsHeader($response);
        return $handler->handle($request);
    }
}