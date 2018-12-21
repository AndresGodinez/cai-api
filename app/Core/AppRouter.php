<?php
/**
 * Created by PhpStorm.
 * User: alberto
 * Date: 13/04/18
 * Time: 12:09 PM
 */

namespace App\Core;

use App\Api\AuthApiView;
use App\Api\User\UserDataApiView;
use App\Core\Middlewares\SecureApiMiddleware;
use App\Factories\ResponseFactory;
use League\Container\Container;
use League\Route\RouteGroup;
use League\Route\Router;
use League\Route\Strategy\ApplicationStrategy;
use Psr\Http\Message\ResponseInterface;

/**
 * Class AppRouter
 * @package App\Core
 */
class AppRouter
{
    /**
     * @param Container $container
     * @return Router
     */
    public function __invoke(Container $container)
    {
        /** @var array $config */
        $config = $container->get('array-config');
        $secureApiMiddleware = new SecureApiMiddleware($config);

        $strategy = new ApplicationStrategy();
        $strategy -> setContainer($container);

        $route = new Router;
        $route -> setStrategy($strategy);

        $route -> addPatternMatcher('regId', '[1-9][0-9]*');

        $route->get('/test', function (): ResponseInterface {
            /** @var ResponseInterface $response */
            $response = ResponseFactory ::buildBasicJsonResponse();

            $response -> getBody() -> write('{"test": true}');

            return $response;
        })
            -> setName('api-test');

        $route->post('/api/auth', AuthApiView::class)->setName('auth-route');

        $r = $route->get('/api/user/{regId:regId}/data', UserDataApiView::class);
        $r->setName('user-data-route');
        $r->middleware($secureApiMiddleware);

        return $route;
    }
}