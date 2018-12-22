<?php
/**
 * Created by IntelliJ IDEA.
 * User: alberto
 * Date: 22/12/18
 * Time: 11:33 AM
 */

namespace App\Core\ContainerProviders;

use App\Api\FurnitureType\FurnitureTypeListApiView;
use League\Container\ServiceProvider\AbstractServiceProvider;

/**
 * Class FurnitureTypeApiProvider
 * @package App\Core\ContainerProviders
 */
class FurnitureTypeApiProvider extends AbstractServiceProvider
{
    protected $provides = [
        FurnitureTypeListApiView::class
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
            ->add(FurnitureTypeListApiView::class)
            ->addMethodCall('setConfig', ['model-config'])
            ->addMethodCall('setEm', ['entity-manager']);
    }
}