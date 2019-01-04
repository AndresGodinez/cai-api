<?php
/**
 * Created by IntelliJ IDEA.
 * User: alberto
 * Date: 4/01/19
 * Time: 11:47 AM
 */

namespace App\Core\ContainerProviders;

use App\Api\Clerk\ClerkCaptureStatisticsApiView;
use League\Container\ServiceProvider\AbstractServiceProvider;

/**
 * Class ClerkApiProvider
 * @package App\Core\ContainerProviders
 */
class ClerkApiProvider extends AbstractServiceProvider
{
    protected $provides = [
        ClerkCaptureStatisticsApiView::class
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
            ->add(ClerkCaptureStatisticsApiView::class)
            ->addMethodCall('setConfig', ['model-config'])
            ->addMethodCall('setEm', ['entity-manager']);
    }
}