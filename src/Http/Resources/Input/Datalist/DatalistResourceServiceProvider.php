<?php

namespace Belvedere\FormMaker\Http\Resources\Input\Datalist;

use Belvedere\FormMaker\Contracts\Resources\DatalistResourcerContract;
use Illuminate\{
    Contracts\Support\DeferrableProvider,
    Support\ServiceProvider
};

class DatalistResourceServiceProvider extends ServiceProvider implements DeferrableProvider
{
    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register(): void
    {
        $this->app->bind(DatalistResourcerContract::class, function ($app, $context) {
            $resource = $app->config->get('form-maker.resources.datalist', new DatalistResourcer($context['datalist']));
            if (is_string($resource)) {
                return new $resource($context['datalist']);
            }
            return $resource;
        });
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return [DatalistResourcerContract::class];
    }
}