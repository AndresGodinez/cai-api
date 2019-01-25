<?php
/**
 * Created by IntelliJ IDEA.
 * User: alberto
 * Date: 4/01/19
 * Time: 10:17 AM
 */

namespace App\Core\ContainerProviders;

use App\Api\AuthApiView;
use App\Api\Indicator\ProgressByBrandApiView;
use App\Api\Indicator\ProgressByStoreApiView;
use App\Api\Indicator\ProgressPercByClerkApiView;
use App\Api\Indicator\ProgressPercByStateApiView;
use App\Api\PhotoUploadSizeTestApiView;
use League\Container\ServiceProvider\AbstractServiceProvider;

/**
 * Class IndicatorApiProvider
 * @package App\Core\ContainerProviders
 */
class IndicatorApiProvider extends AbstractServiceProvider
{
    protected $provides = [
        ProgressPercByClerkApiView::class,
        ProgressPercByStateApiView::class,
        ProgressByBrandApiView::class,
        ProgressByStoreApiView::class
    ];

    /**
     * Use the register method to register items with the container via the
     * protected $this->container property or the `getContainer` method
     * from the ContainerAwareTrait.
     *
     * @return void
     */
    public function register()
    {
        $this->container
            ->add(ProgressPercByClerkApiView::class)
            ->addMethodCall('setConfig', ['model-config'])
            ->addMethodCall('setEm', ['entity-manager']);

        $this->container
            ->add(ProgressPercByStateApiView::class)
            ->addMethodCall('setConfig', ['model-config'])
            ->addMethodCall('setEm', ['entity-manager']);

        $this->container
            ->add(ProgressByBrandApiView::class)
            ->addMethodCall('setConfig', ['model-config'])
            ->addMethodCall('setEm', ['entity-manager']);

        $this->container
            ->add(ProgressByStoreApiView::class)
            ->addMethodCall('setConfig', ['model-config'])
            ->addMethodCall('setEm', ['entity-manager']);
    }
}
