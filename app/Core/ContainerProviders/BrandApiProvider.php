<?php
/**
 * Created by IntelliJ IDEA.
 * User: alberto
 * Date: 22/12/18
 * Time: 11:11 AM
 */

namespace App\Core\ContainerProviders;

use App\Api\Brand\BrandFurnitureTypeListApiView;
use App\Api\Brand\BrandListApiView;
use League\Container\ServiceProvider\AbstractServiceProvider;

/**
 * Class BrandApiProvider
 * @package App\Core\ContainerProviders
 */
class BrandApiProvider extends AbstractServiceProvider
{
    protected $provides = [
        BrandListApiView::class,
        BrandFurnitureTypeListApiView::class,
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
            ->add(BrandListApiView::class)
            ->addMethodCall('setConfig', ['model-config'])
            ->addMethodCall('setEm', ['entity-manager']);

        $this->container
            ->add(BrandFurnitureTypeListApiView::class)
            ->addMethodCall('setConfig', ['model-config'])
            ->addMethodCall('setEm', ['entity-manager']);
    }
}