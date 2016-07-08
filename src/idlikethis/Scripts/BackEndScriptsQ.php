<?php

class idlikethis_Scripts_BackEndScriptsQ implements idlikethis_Scripts_BackEndScriptsQInterface
{
    /**
     * @var idlikethis_Plugin
     */
    protected $plugin;

    /**
     * @var idlikethis_Scripts_BackEndDataProviderInterface
     */
    protected $data_provider;

    /**
     * idlikethis_Scripts_BackEndScriptsQ constructor.
     * @param idlikethis_Plugin $plugin
     * @param idlikethis_Scripts_BackEndDataProviderInterface $data_provider
     */
    public function __construct(idlikethis_Plugin $plugin, idlikethis_Scripts_BackEndDataProviderInterface $data_provider)
    {
        $this->plugin = $plugin;
        $this->data_provider = $data_provider;
    }

    /**
     * Enqueues the needed scripts and styles.
     */
    public function enqueue()
    {
        $bundle_url = $this->plugin->dir_url('assets/js/dist/idlikethis-admin.js');
        wp_enqueue_script('idlikethis-admin', $bundle_url, array('backbone'), null, true);
        $data = $this->data_provider->get_data();
        wp_localize_script('idlikethis-admin', 'idlikethisData', $data);
        wp_nonce_field( 'wp_rest', 'rest_nonce' );
    }
}