<?php

class idlikethis_Scripts_FrontEndScriptsQ implements idlikethis_Scripts_FrontEndScriptsQInterface
{
    /**
     * @var idlikethis_Plugin
     */
    protected $plugin;

    /**
     * @var idlikethis_Scripts_FrontEndDataProviderInterface
     */
    protected $data_provider;

    /**
     * idlikethis_Scripts_FrontEndScriptsQ constructor.
     * @param idlikethis_Plugin $plugin
     * @param idlikethis_Scripts_FrontEndDataProviderInterface $data_provider
     */
    public function __construct(idlikethis_Plugin $plugin, idlikethis_Scripts_FrontEndDataProviderInterface $data_provider)
    {
        $this->plugin = $plugin;
        $this->data_provider = $data_provider;
    }

    /**
     * Enqueues the needed scripts and styles.
     */
    public function enqueue()
    {
        $bundle_url = $this->plugin->dir_url('assets/js/dist/idlikethis-bundle.js');
        wp_enqueue_script('idlikethis-bundle', $bundle_url, array('backbone'), null, true);
        $data = $this->data_provider->get_data();
        wp_localize_script('idlikethis-bundle', 'idlikethisData', $data);
    }
}