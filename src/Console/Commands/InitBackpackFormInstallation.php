<?php

namespace MedianetDev\BackpackForm\Console\Commands;

use Illuminate\Support\Str;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\File;

class InitBackpackFormInstallation extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'backpack-form:installation';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Script call after installation via composer';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $name = __('medianet-dev.backpack-form::formbuilder.labels.entity');
        $nameTitle = ucfirst(Str::camel($name));
        $nameKebab = 'formbuilder';
        $namePlural = ucfirst(__('medianet-dev.backpack-form::formbuilder.labels.entities_form'));

        $this->call('migrate');

        $this->call('vendor:publish', [
            '--provider' => "MedianetDev\BackpackForm\AddonServiceProvider",
            '--tag' => "config"
        ]);
        $this->call('vendor:publish', [
            '--provider' => "MedianetDev\BackpackForm\AddonServiceProvider",
            '--tag' => "assets"
        ]);

        $this->call('vendor:publish', [
            '--provider' => "MedianetDev\BackpackForm\AddonServiceProvider",
            '--tag' => "views"
        ]);

        // Check if sidebar item already exists before adding it
        $this->addSidebarItemIfNotExists($nameKebab);

        // if the application uses cached routes, we should rebuild the cache so the previous added route will
        // be acessible without manually clearing the route cache.
        if (app()->routesAreCached()) {
            $this->call('route:cache');
        }
    }

    /**
     * Add the sidebar item only if it doesn't already exist in the sidebar_content file
     *
     * @param string $nameKebab
     * @return void
     */
    protected function addSidebarItemIfNotExists($nameKebab)
    {
        // Path to the Backpack sidebar_content file
        $sidebarPath = resource_path('views/vendor/backpack/base/inc/sidebar_content.blade.php');

        // Check if the sidebar content file exists
        if (!File::exists($sidebarPath)) {
            $this->warn('Sidebar content file not found. Creating sidebar item anyway.');
            $this->addSidebarItem($nameKebab);
            return;
        }

        // Get the content of the sidebar file
        $sidebarContent = File::get($sidebarPath);

        // Check if the sidebar already contains a link to the formbuilder
        if (Str::contains($sidebarContent, "backpack_url('$nameKebab')") ||
            Str::contains($sidebarContent, "{{ __('sidebar.forms_list') }}")) {
            $this->info('Formbuilder sidebar item already exists. Skipping.');
        } else {
            $this->info('Adding Formbuilder sidebar item.');
            $this->addSidebarItem($nameKebab);
        }
    }

    /**
     * Add the sidebar item
     *
     * @param string $nameKebab
     * @return void
     */
    protected function addSidebarItem($nameKebab)
    {
        $this->call('backpack:add-sidebar-content', [
            'code' => "
                @canany(['create_form', 'list_form', 'update_form', 'delete_form'])
                    <li class='nav-item'>
                        <a class='nav-link' href='{{ backpack_url('$nameKebab') }}'>
                            <i class='nav-icon la la-database'></i>
                            {{ __('sidebar.forms_list') }}
                        </a>
                    </li>
                @endcanany
            ",
        ]);
    }
}
