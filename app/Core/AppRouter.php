<?php
/**
 * Created by PhpStorm.
 * User: alberto
 * Date: 13/04/18
 * Time: 12:09 PM
 */

namespace App\Core;

use App\Api\AuthApiView;
use App\Api\Brand\BrandFurnitureTypeListApiView;
use App\Api\Brand\BrandListApiView;
use App\Api\Clerk\ClerkCaptureStatisticsApiView;
use App\Api\FurnitureType\FurnitureTypeListApiView;
use App\Api\Indicator\ProgressByBrandApiView;
use App\Api\Indicator\ProgressByStoreApiView;
use App\Api\Indicator\ProgressPercByClerkApiView;
use App\Api\Indicator\ProgressPercByStateApiView;
use App\Api\InventoryEvidence\GetInventoryEvidenceApiView;
use App\Api\InventoryEvidence\GetPhotosInventoryApiView;
use App\Api\InventoryEvidence\GetPhotoZipApiView;
use App\Api\InventoryEvidence\GetReportEvidenceApiView;
use App\Api\InventoryEvidence\GetTotalInventoryFilterByDateApiView;
use App\Api\InventoryEvidence\InventoryEvidenceCreateApiView;
use App\Api\InventoryEvidence\InventoryEvidenceReadRegistersApiView;
use App\Api\InventoryEvidence\InventoryEvidenceReadRegistersCountApiView;
use App\Api\InventoryEvidence\PendingStoreReportApiView;
use App\Api\InventoryEvidencePhoto\InventoryEvidencePhotoReadPhotoContentApiView;
use App\Api\PhotoUploadSizeTestApiView;
use App\Api\User\UserDataApiView;
use App\Core\Middlewares\SecureApiMiddleware;
use App\Core\Middlewares\SecureApiQueryParamMiddleware;
use App\Core\Middlewares\ValidatePhotoUploadSizesApiMiddleware;
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
        $validatePhotoUploadSizeApiMiddleware = new ValidatePhotoUploadSizesApiMiddleware($config);

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


        $route->get('/api/version', function () use ($config): ResponseInterface {
            /** @var ResponseInterface $response */
            $response = ResponseFactory ::buildBasicJsonResponse();

            $version = $config["APP_VERSION"] ?? '';
            $response -> getBody() -> write(\json_encode([
                "version" => $version,
            ]));

            return $response;
        })
            -> setName('api-test');

        $route->post('/api/auth', AuthApiView::class)->setName('auth-route');

        $r = $route->POST('/api/photo-upload-size-test', PhotoUploadSizeTestApiView::class);
        $r->setName('photo-upload-size-test-route');
        $r->middleware($secureApiMiddleware);
        $r->middleware($validatePhotoUploadSizeApiMiddleware);

        $r = $route->get('/api/user/{regId:regId}/data', UserDataApiView::class);
        $r->setName('user-data-route');
        $r->middleware($secureApiMiddleware);

        $r = $route->get('/api/brand/list', BrandListApiView::class);
        $r->setName('brand-list-route');
        $r->middleware($secureApiMiddleware);

        $r = $route->get('/api/brand/{regId:regId}/furniture-type/list', BrandFurnitureTypeListApiView::class);
        $r->setName('brand-furniture-type-list-route');
        $r->middleware($secureApiMiddleware);

        $r = $route->get('/api/furniture-type/list', FurnitureTypeListApiView::class);
        $r->setName('furniture-type-list-route');
        $r->middleware($secureApiMiddleware);

        $r = $route->post('/api/inventory-evidence', InventoryEvidenceCreateApiView::class);
        $r->setName('inventory-evidence-create-route');
        $r->middleware($secureApiMiddleware);
        $r->middleware($validatePhotoUploadSizeApiMiddleware);

        $r = $route->get('/api/inventory-evidence', InventoryEvidenceReadRegistersApiView::class);
        $r->setName('inventory-evidence-read-registers-route');
        $r->middleware($secureApiMiddleware);

        $r = $route->get('/api/inventory-evidence/count', InventoryEvidenceReadRegistersCountApiView::class);
        $r->setName('inventory-evidence-read-registers-count-route');
        $r->middleware($secureApiMiddleware);

        $r = $route->get('/api/inventory-evidence-photo/{regId:regId}', InventoryEvidencePhotoReadPhotoContentApiView::class);
        $r->setName('inventory-evidence-photo-read-photo-content-route');
        $r->middleware($secureApiQueryParamMiddleware);

        $r = $route->get('/api/clerk/{regId:regId}/capture-statistics', ClerkCaptureStatisticsApiView::class);
        $r->setName('clerk-capture-statistics-route');
        $r->middleware($secureApiMiddleware);

        // indicator routes

        $r = $route->get('/api/indicator/progress-perc-by-clerk', ProgressPercByClerkApiView::class);
        $r->setName('indicator-progress-perc-by-clerk-route');

        $r = $route->get('/api/indicator/progress-perc-by-state', ProgressPercByStateApiView::class);
        $r->setName('indicator-progress-perc-by-state-route');

        $r = $route->get('/api/indicator/progress-by-brand', ProgressByBrandApiView::class);
        $r->setName('indicator-progress-by-brand-route');

        $r = $route->get('/api/indicator/progress-by-stores', ProgressByStoreApiView::class);
        $r->setName('indicator-progress-by-stores-route');

        //routes to dashboard

        $r = $route->get('/api/get-inventory-evidence', GetInventoryEvidenceApiView::class);
        $r->setName('get-inventory-evidence');

        //routes to reports

        $r = $route->get('/api/report/getProgressEvidenceByDate', GetReportEvidenceApiView::class );
        $r->setName('get-report-evidence-by-date');

        $r = $route->get('/api/report/pendingStores', PendingStoreReportApiView::class );
        $r->setName('pending-store-report');

        $r = $route->get('/api/report/getTotalInventoryFilterByDate', GetTotalInventoryFilterByDateApiView::class );
        $r->setName('get-total-inventory-filter-by-date');

        $r = $route->get('/api/report/getPhotosInventory', GetPhotosInventoryApiView::class );
        $r->setName('get-photos-inventory');


        $r = $route->get('/api/report/getPhotosZip', GetPhotoZipApiView::class );
        $r->setName('get-photos-zip-inventory');


        return $route;
    }
}
