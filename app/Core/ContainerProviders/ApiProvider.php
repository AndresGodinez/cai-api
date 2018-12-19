<?php
/**
 * Created by PhpStorm.
 * User: alberto
 * Date: 12/10/18
 * Time: 09:59 AM
 */

namespace App\Core\ContainerProviders;

use App\Api\Agent\AgentGetAssignedVotingBoothsApiView;
use App\Api\AuthApiView;
use App\Api\Candidate\CandidateGetAllApiView;
use App\Api\SectionsApiView;
use App\Api\TestApiView;
use League\Container\ServiceProvider\AbstractServiceProvider;

/**
 * Class Api
 * @package App\Core\ContainerProviders
 */
class ApiProvider extends AbstractServiceProvider
{
    protected $provides = [
        TestApiView::class,
        SectionsApiView::class,

        AgentGetAssignedVotingBoothsApiView::class,

        AuthApiView::class
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
            ->add(TestApiView::class)
            ->addMethodCall('setConfig', ['model-config'])
            ->addMethodCall('setEm', ['entity-manager']);
        $this->container
            ->add(SectionsApiView::class)
            ->addMethodCall('setConfig', ['model-config'])
            ->addMethodCall('setEm', ['entity-manager']);

        $this->container
            ->add(AuthApiView::class)
            ->addMethodCall('setConfig', ['model-config'])
            ->addMethodCall('setEm', ['entity-manager']);

        $this->container
            ->add(CandidateGetAllApiView::class)
            ->addMethodCall('setConfig', ['model-config'])
            ->addMethodCall('setEm', ['entity-manager']);
    }
}