<?php

class idlikethis_ServiceProviders_Scripts extends tad_DI52_ServiceProvider
{

    /**
     * Binds and sets up implementations.
     */
    public function register()
    {
        $this->container->bind('idlikethis_Scripts_FrontEndDataProviderInterface','idlikethis_Scripts_FrontEndDataProvider');
        $this->container->singleton('idlikethis_Scripts_FrontEndScriptsQInterface', 'idlikethis_Scripts_FrontEndScriptsQ');

        add_action('wp_enqueue_scripts', array($this->container->make('idlikethis_Scripts_FrontEndScriptsQInterface'), 'enqueue'));
    }

    /**
     * Binds and sets up implementations at boot time.
     */
    public function boot()
    {
        // TODO: Implement boot() method.
    }
}