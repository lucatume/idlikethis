<?php

class idlikethis_ServiceProviders_Endpoints extends tad_DI52_ServiceProvider
{

    /**
     * Binds and sets up implementations.
     */
    public function register()
    {
        $this->container->setVar('endpoints-namespace', 'idlikethis/v1');

        $this->container->singleton('idlikethis_Endpoints_AuthHandlerInterface', 'idlikethis_Endpoints_AuthHandler');
        $this->container->singleton('idlikethis_Endpoints_PostAdminAuthHandlerInterface', 'idlikethis_Endpoints_PostAdminAuthHandler');
        $this->container->singleton('idlikethis_Repositories_VotesRepositoryInterface', 'idlikethis_Repositories_CommentsRepository');
        $this->container->singleton('idlikethis_Endpoints_ButtonClickHandlerInterface', 'idlikethis_Endpoints_ButtonClickHandler');
        $this->container->singleton('idlikethis_Endpoints_ResetAllHandlerInterface', 'idlikethis_Endpoints_ResetAllHandler');
        $this->container->singleton('idlikethis_Endpoints_ConsolidateAllHandlerInterface', 'idlikethis_Endpoints_ConsolidateAllHandler');

        add_action('rest_api_init', array($this, 'register_endpoints'));
    }

    public function register_endpoints()
    {
        $namespace = $this->container->getVar('endpoints-namespace');

        register_rest_route($namespace, '/button-click', array(
            'methods' => 'POST',
            'callback' => array($this->container->make('idlikethis_Endpoints_ButtonClickHandlerInterface'), 'handle'),
        ));

        register_rest_route($namespace, '/admin/reset-all', array(
            'methods' => 'POST',
            'callback' => array($this->container->make('idlikethis_Endpoints_ResetAllHandlerInterface'), 'handle'),
        ));

        register_rest_route($namespace, '/admin/consolidate-all', array(
            'methods' => 'POST',
            'callback' => array($this->container->make('idlikethis_Endpoints_ConsolidateAllHandlerInterface'), 'handle'),
        ));
    }

    /**
     * Binds and sets up implementations at boot time.
     */
    public function boot()
    {
        // TODO: Implement boot() method.
    }
}