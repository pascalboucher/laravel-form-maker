<?php

namespace Belvedere\FormMaker\Repositories;

use Illuminate\Support\ServiceProvider;
use Illuminate\Contracts\Support\DeferrableProvider;
use Belvedere\FormMaker\Contracts\Repositories\NodeRepositoryContract;

class NodeRepositoryServiceProvider extends ServiceProvider implements DeferrableProvider
{
    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register(): void
    {
        $this->app->singleton(NodeRepositoryContract::class, function ($app) {
            $nodeRepository = $app->config->get('form-maker.repositories.node_repository', new NodeRepository());
            if (is_string($nodeRepository)) {
                return new $nodeRepository();
            }

            return $nodeRepository;
        });
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return [NodeRepositoryContract::class];
    }
}
