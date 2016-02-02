<?php

class idlikethis_ServiceProviders_Endpoints extends tad_DI52_ServiceProvider
{

    /**
     * Binds and sets up implementations.
     */
    public function register()
    {
        $this->container->set_var('endpoints-namespace', 'idlikethis/v1');

        $this->container->singleton('idlikethis_Endpoints_AuthHandlerInterface', 'idlikethis_Endpoints_AuthHandler');
        $this->container->singleton('idlikethis_Repositories_CommentsRepositoryInterface', 'idlikethis_Repositories_CommentsRepository');
        $this->container->singleton('idlikethis_Endpoints_ButtonClickHandlerInterface', 'idlikethis_Endpoints_ButtonClickHandler');


        add_action('rest_api_init', array($this, 'register_endpoints'));
    }

    public function register_endpoints()
    {
        $namespace = $this->container->get_var('endpoints-namespace');

        register_rest_route($namespace, '/button-click/', array(
            'methods' => 'POST',
            'callback' => array($this->container->make('idlikethis_Endpoints_ButtonClickHandlerInterface'), 'handle'),
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