<?php
/**
 * Created by PhpStorm.
 * User: alberto
 * Date: 12/10/18
 * Time: 09:59 AM
 */

namespace App\Core\ContainerProviders;

use App\Api\AuthApiView;
use App\Api\InventoryEvidence\GetReportEvidenceApiView;
use App\Api\PhotoUploadSizeTestApiView;
use League\Container\ServiceProvider\AbstractServiceProvider;

/**
 * Class Api
 * @package App\Core\ContainerProviders
 */
class ApiProvider extends AbstractServiceProvider
{
    protected $provides = [
        AuthApiView::class,
        PhotoUploadSizeTestApiView::class,
        GetReportEvidenceApiView::class
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
            ->add(AuthApiView::class)
            ->addMethodCall('setConfig', ['model-config'])
            ->addMethodCall('setEm', ['entity-manager']);

        $this->container
            ->add(PhotoUploadSizeTestApiView::class)
            ->addMethodCall('setConfig', ['model-config']);

        $this->container
            ->add(GetReportEvidenceApiView::class)
            ->addMethodCall('setConfig', ['model-config'])
            ->addMethodCall('setEm', ['entity-manager']);

    }
}