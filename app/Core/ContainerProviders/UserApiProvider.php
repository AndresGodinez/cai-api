<?php
/**
 * Created by IntelliJ IDEA.
 * User: alberto
 * Date: 21/12/18
 * Time: 03:47 PM
 */

namespace App\Core\ContainerProviders;

use App\Api\User\UserDataApiView;
use League\Container\ServiceProvider\AbstractServiceProvider;

/**
 * Class UserApiProvider
 * @package App\Core\ContainerProviders
 */
class UserApiProvider extends AbstractServiceProvider
{
    protected $provides = [
        UserDataApiView::class
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
            ->add(UserDataApiView::class)
            ->addMethodCall('setConfig', ['model-config'])
            ->addMethodCall('setEm', ['entity-manager']);
    }
}