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
use App\Core\ContainerProviders\ModelsProvider;
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

        return $container;
    }
}
