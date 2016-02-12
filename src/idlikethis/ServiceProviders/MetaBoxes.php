<?php

class idlikethis_ServiceProviders_MetaBoxes extends tad_DI52_ServiceProvider
{

    /**
     * Binds and sets up implementations.
     */
    public function register()
    {
        add_action('add_meta_boxes', array($this, 'add_meta_boxes'));
    }

    public function add_meta_boxes()
    {
        $this->container->bind('idlikethis_MetaBoxes_VotesDisplayMetaBoxInterface', 'idlikethis_MetaBoxes_VotesDisplayMetaBox');
        $this->container->bind('idlikethis_MetaBoxes_PostControlMetaBoxInterface', 'idlikethis_MetaBoxes_PostControlMetaBox');

        $this->container->tag(array(
            'idlikethis_MetaBoxes_VotesDisplayMetaBoxInterface',
            'idlikethis_MetaBoxes_PostControlMetaBoxInterface',
        ), 'meta-boxes');

        /** @var idlikethis_MetaBoxes_MetaBoxInterface $meta_box */
        foreach ($this->container->tagged('meta-boxes') as $meta_box) {
            add_meta_box($meta_box->id(), $meta_box->title(), array($meta_box, 'render'), $meta_box->screen(), $meta_box->context(), $meta_box->priority());
        }
    }

    /**
     * Binds and sets up implementations at boot time.
     */
    public function boot()
    {
        // TODO: Implement boot() method.
    }
}