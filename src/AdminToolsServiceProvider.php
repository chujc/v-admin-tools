<?php

namespace ChuJC\Admin;

use ChuJC\Admin\Commands\ToolsInstallCommand;
use Illuminate\Support\ServiceProvider;

class AdminToolsServiceProvider extends ServiceProvider
{
    /**
     * @var array
     */
    protected $commands = [
        ToolsInstallCommand::class,
    ];

    /**
     * Boot the service provider.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPublishing();
    }

    /**
     * Register the package's publishable resources.
     *
     * @return void
     */
    protected function registerPublishing()
    {
        if ($this->app->runningInConsole()) {
            $this->publishes([__DIR__ . '/../database/migrations' => database_path('migrations')], 'v-admin-tools-migrations');
        }
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->commands($this->commands);
    }

}
