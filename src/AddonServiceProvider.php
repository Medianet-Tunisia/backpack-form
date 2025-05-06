<?php

namespace MedianetDev\BackpackForm;

use Illuminate\Support\ServiceProvider;

class AddonServiceProvider extends ServiceProvider
{
    use AutomaticServiceProvider;

    protected $vendorName = 'medianet-dev';
    protected $packageName = 'backpack-form';
    protected $commands = [
        \MedianetDev\BackpackForm\Console\Commands\InitBackpackFormInstallation::class
    ];

    /**
     * Perform post-registration booting of services.
     *
     * @return void
     */
    public function boot()
    {
        if (
            $this->packageDirectoryExistsAndIsNotEmpty('bootstrap') &&
            file_exists($helpers = $this->packageHelpersFile())
        ) {
            require $helpers;
        }

        // Publishing the configuration file.
        if ($this->packageDirectoryExistsAndIsNotEmpty('config')) {
            $this->publishes([
                $this->packageConfigFile() => $this->publishedConfigFile(),
            ], 'config');
        }

        if ($this->packageDirectoryExistsAndIsNotEmpty('resources/lang')) {
            $this->loadTranslationsFrom($this->packageLangsPath(), $this->vendorNameDotPackageName());
        }

        // if ($this->packageDirectoryExistsAndIsNotEmpty('resources/views')) {
        //     // Load published views
        //     $this->loadViewsFrom($this->publishedViewsPath(), $this->vendorNameDotPackageName());

        //     // Fallback to package views
        //     $this->loadViewsFrom($this->packageViewsPath(), $this->vendorNameDotPackageName());

        // }

        if ($this->packageDirectoryExistsAndIsNotEmpty('database/migrations')) {
            $this->loadMigrationsFrom($this->packageMigrationsPath());
        }

        if ($this->packageDirectoryExistsAndIsNotEmpty('routes')) {
            $this->loadRoutesFrom($this->packageRoutesFile());
        }
    // Load views
    $this->loadViewsFrom(dirname(__DIR__).'/resources/views', 'backpack-form');

    // Register views for publishing
    $this->publishes([
        dirname(__DIR__).'/resources/views/fields' => resource_path('views/vendor/backpack/crud/fields'),
    ], 'views');

        // Publishing is only necessary when using the CLI.
        if ($this->app->runningInConsole()) {
            $this->bootForConsole();
        }
    }

    /**
     * Console-specific booting.
     *
     * @return void
     */
    protected function bootForConsole(): void
    {





        // Publishing assets.
        if ($this->packageDirectoryExistsAndIsNotEmpty('resources/assets')) {
            $this->publishes([
                $this->packageAssetsPath() => $this->publishedAssetsPath(),
            ], 'assets');
        }
        // if ($this->packageDirectoryExistsAndIsNotEmpty('resources/views')) {
        //     $this->publishes([
        //         $this->packageViewsPath() => $this->publishedViewsPath(),
        //     ], 'views');
        // }

        // Registering package commands.
        if (!empty($this->commands)) {
            $this->commands($this->commands);
        }
    }
    // register command for installation and other
    public function register()
    {
        $this->commands($this->commands);
    }
}
