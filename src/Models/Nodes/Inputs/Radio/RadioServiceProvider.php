<?php

namespace Belvedere\FormMaker\Models\Nodes\Inputs\Radio;

use Illuminate\Support\ServiceProvider;
use Illuminate\Contracts\Support\DeferrableProvider;
use Belvedere\FormMaker\Contracts\Models\Nodes\Inputs\Radio\RadioerContract;

class RadioServiceProvider extends ServiceProvider implements DeferrableProvider
{
    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register(): void
    {
        $this->app->bind(RadioerContract::class, function ($app) {
            $radioer = $app->config->get('form-maker.nodes.inputs.radio', new Radioer());
            if (is_string($radioer)) {
                return new $radioer();
            }

            return $radioer;
        });
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return [RadioerContract::class];
    }
}
