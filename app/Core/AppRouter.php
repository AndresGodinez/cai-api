<?php
/**
 * Created by PhpStorm.
 * User: alberto
 * Date: 13/04/18
 * Time: 12:09 PM
 */

namespace App\Core;

use App\Api\AuthApiView;
use App\Api\Brand\BrandListApiView;
use App\Api\FurnitureType\FurnitureTypeListApiView;
use App\Api\InventoryEvidence\InventoryEvidenceCreateApiView;
use App\Api\InventoryEvidence\InventoryEvidenceReadRegistersApiView;
use App\Api\InventoryEvidencePhoto\InventoryEvidencePhotoReadPhotoContentApiView;
use App\Api\User\UserDataApiView;
use App\Core\Middlewares\SecureApiMiddleware;
use App\Core\Middlewares\SecureApiQueryParamMiddleware;
use App\Factories\ResponseFactory;
use League\Container\Container;
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
        $secureApiQueryParamMiddleware = new SecureApiQueryParamMiddleware($config);

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

        $r = $route->get('/api/brand/list', BrandListApiView::class);
        $r->setName('brand-list-route');
        $r->middleware($secureApiMiddleware);

        $r = $route->get('/api/furniture-type/list', FurnitureTypeListApiView::class);
        $r->setName('furniture-type-list-route');
        $r->middleware($secureApiMiddleware);

        $r = $route->post('/api/inventory-evidence', InventoryEvidenceCreateApiView::class);
        $r->setName('inventory-evidence-create-route');
        $r->middleware($secureApiMiddleware);

        $r = $route->get('/api/inventory-evidence', InventoryEvidenceReadRegistersApiView::class);
        $r->setName('inventory-evidence-read-registers-route');
        $r->middleware($secureApiMiddleware);

        $r = $route->get('/api/inventory-evidence-photo/{regId:regId}', InventoryEvidencePhotoReadPhotoContentApiView::class);
        $r->setName('inventory-evidence-photo-read-photo-content-route');
        $r->middleware($secureApiQueryParamMiddleware);

        return $route;
    }
}