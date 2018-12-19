<?php
/**
 * Created by PhpStorm.
 * User: alberto
 * Date: 4/09/18
 * Time: 01:59 PM
 */

namespace App\Core\ContainerProviders;

use League\Container\ServiceProvider\AbstractServiceProvider;

/**
 * Class ModelsProvider
 * @package App\Core\ContainerProviders
 */
class ModelsProvider extends AbstractServiceProvider
{
    protected $provides = [
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
    }
}