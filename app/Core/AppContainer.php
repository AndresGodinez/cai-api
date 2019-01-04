<?php
/**
 * Created by PhpStorm.
 * User: alberto
 * Date: 13/04/18
 * Time: 12:08 PM
 */

namespace App\Core;

use App\Core\ContainerProviders\ApiProvider;
use App\Core\ContainerProviders\BaseProvider;
use App\Core\ContainerProviders\BrandApiProvider;
use App\Core\ContainerProviders\ClerkApiProvider;
use App\Core\ContainerProviders\FurnitureTypeApiProvider;
use App\Core\ContainerProviders\IndicatorApiProvider;
use App\Core\ContainerProviders\InventoryEvidenceApiProvider;
use App\Core\ContainerProviders\InventoryEvidencePhotoApiProvider;
use App\Core\ContainerProviders\ModelsProvider;
use App\Core\ContainerProviders\UserApiProvider;
use League\Container\Container;

/**
 * Class AppContainer
 * @package App\Core
 */
class AppContainer
{
    /**
     * @param string $baseDir
     * @return Container
     */
    public static function make(string $baseDir)
    {
        $container = new Container();

        # base provider (share utils)
        $container->addServiceProvider(new BaseProvider($baseDir));

        $container->addServiceProvider(new ModelsProvider);

        $container->addServiceProvider(new ApiProvider);

        $container->addServiceProvider(new UserApiProvider);

        $container->addServiceProvider(new ClerkApiProvider);

        $container->addServiceProvider(new BrandApiProvider);

        $container->addServiceProvider(new FurnitureTypeApiProvider);

        $container->addServiceProvider(new InventoryEvidenceApiProvider);

        $container->addServiceProvider(new InventoryEvidencePhotoApiProvider);

        $container->addServiceProvider(new IndicatorApiProvider);

        return $container;
    }
}
