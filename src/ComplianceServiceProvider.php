<?php

namespace Dokan\Compliance;

use Illuminate\Support\ServiceProvider;

class ComplianceServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->mergeConfigFrom(
            __DIR__.'/../config/compliance.php', 'compliance'
        );

        $this->app->singleton(ComplianceClient::class, function ($app) {
            return new ComplianceClient(
                config('compliance.api_url'),
                config('compliance.api_key')
            );
        });
    }

    public function boot()
    {
        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__.'/../config/compliance.php' => config_path('compliance.php'),
            ], 'compliance-config');
        }
    }
} 