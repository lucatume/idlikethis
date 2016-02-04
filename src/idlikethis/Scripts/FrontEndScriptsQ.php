<?php

class idlikethis_Scripts_FrontEndScriptsQ implements idlikethis_Scripts_FrontEndScriptsQInterface
{
    /**
     * @var idlikethis_Plugin
     */
    protected $plugin;

    /**
     * idlikethis_Scripts_FrontEndScriptsQ constructor.
     * @param idlikethis_Plugin $plugin
     */
    public function __construct(idlikethis_Plugin $plugin)
    {
        $this->plugin = $plugin;
    }

    /**
     * Enqueues the needed scripts and styles.
     */
    public function enqueue()
    {
        $bundle_url = $this->plugin->dir_url('assets/js/dist/idlikethis-bundle.js');
        wp_enqueue_script('idlikethis-bundle', $bundle_url, array('backbone'), null, true);
    }
}