<?php

class idlikethis_ServiceProviders_CommentsTable extends tad_DI52_ServiceProvider
{

    /**
     * Binds and sets up implementations.
     */
    public function register()
    {
        $this->container->bind('idlikethis_Comments_TableContextInterface', 'idlikethis_Comments_TableContext');
        $this->container->bind('idlikethis_Comments_TableFilterInterface', 'idlikethis_Comments_TableFilter');

        add_filter('pre_get_comments', array($this->container->resolve('idlikethis_Comments_TableFilterInterface'), 'on_pre_get_comments'), 10, 1);

    }

    /**
     * Binds and sets up implementations at boot time.
     */
    public function boot()
    {
        // TODO: Implement boot() method.
    }
}