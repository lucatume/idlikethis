<?php

class idlikethis_ServiceProviders_Scripts extends tad_DI52_ServiceProvider
{

    /**
     * Binds and sets up implementations.
     */
    public function register()
    {
        $this->container->singleton('idlikethis_Scripts_FrontEndDataProviderInterface','idlikethis_Scripts_FrontEndDataProvider');
        $this->container->singleton('idlikethis_Scripts_FrontEndScriptsQInterface', 'idlikethis_Scripts_FrontEndScriptsQ');

        $this->container->singleton('idlikethis_Scripts_BackEndDataProviderInterface','idlikethis_Scripts_BackEndDataProvider');
        $this->container->singleton('idlikethis_Scripts_BackEndScriptsQInterface', 'idlikethis_Scripts_BackEndScriptsQ');

        add_action('wp_enqueue_scripts', array($this->container->make('idlikethis_Scripts_FrontEndScriptsQInterface'), 'enqueue'));
        add_action('admin_enqueue_scripts', array($this->container->make('idlikethis_Scripts_BackEndScriptsQInterface'), 'enqueue'));
    }

    /**
     * Binds and sets up implementations at boot time.
     */
    public function boot()
    {
        // TODO: Implement boot() method.
    }
}