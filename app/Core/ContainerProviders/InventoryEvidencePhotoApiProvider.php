<?php
/**
 * Created by IntelliJ IDEA.
 * User: alberto
 * Date: 27/12/18
 * Time: 06:53 PM
 */

namespace App\Core\ContainerProviders;

use App\Api\InventoryEvidencePhoto\InventoryEvidencePhotoReadPhotoContentApiView;
use League\Container\ServiceProvider\AbstractServiceProvider;

/**
 * Class InventoryEvidencePhotoApiProvider
 * @package App\Core\ContainerProviders
 */
class InventoryEvidencePhotoApiProvider extends AbstractServiceProvider
{
    protected $provides = [
        InventoryEvidencePhotoReadPhotoContentApiView::class,
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
            ->add(InventoryEvidencePhotoReadPhotoContentApiView::class)
            ->addMethodCall('setConfig', ['model-config'])
            ->addMethodCall('setEm', ['entity-manager'])
            ->addMethodCall('setPhotosStorage', ['inventory-evidence-photos-filesystem']);
    }
}