<?php
/**
 * Created by IntelliJ IDEA.
 * User: alberto
 * Date: 4/01/19
 * Time: 10:17 AM
 */

namespace App\Core\ContainerProviders;

use App\Api\AuthApiView;
use App\Api\Indicator\ProgressPercByClerkApiView;
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
    }
}