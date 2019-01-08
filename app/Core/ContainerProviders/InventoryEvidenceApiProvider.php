<?php
/**
 * Created by IntelliJ IDEA.
 * User: alberto
 * Date: 27/12/18
 * Time: 11:13 AM
 */

namespace App\Core\ContainerProviders;

use App\Api\InventoryEvidence\InventoryEvidenceCreateApiView;
use App\Api\InventoryEvidence\InventoryEvidenceReadRegistersApiView;
use App\Api\InventoryEvidence\InventoryEvidenceReadRegistersCountApiView;
use League\Container\ServiceProvider\AbstractServiceProvider;

/**
 * Class InventoryEvidenceApiProvider
 * @package App\Core\ContainerProviders
 */
class InventoryEvidenceApiProvider extends AbstractServiceProvider
{
    protected $provides = [
        InventoryEvidenceCreateApiView::class,
        InventoryEvidenceReadRegistersApiView::class,
        InventoryEvidenceReadRegistersCountApiView::class,
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
            ->add(InventoryEvidenceCreateApiView::class)
            ->addMethodCall('setConfig', ['model-config'])
            ->addMethodCall('setEm', ['entity-manager'])
            ->addMethodCall('setPhotosStorage', ['inventory-evidence-photos-filesystem']);

        $this->container
            ->add(InventoryEvidenceReadRegistersApiView::class)
            ->addMethodCall('setConfig', ['model-config'])
            ->addMethodCall('setEm', ['entity-manager']);

        $this->container
            ->add(InventoryEvidenceReadRegistersCountApiView::class)
            ->addMethodCall('setConfig', ['model-config'])
            ->addMethodCall('setEm', ['entity-manager']);
    }
}