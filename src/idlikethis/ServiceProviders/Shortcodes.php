<?php

class idlikethis_ServiceProviders_Shortcodes extends tad_DI52_ServiceProvider
{

    /**
     * Binds and sets up implementations.
     */
    public function register()
    {
        $this->container->singleton('idlikethis_Plugin', new idlikethis_Plugin());
        $templates_dir = $this->container->resolve('idlikethis_Plugin')->dir_path('templates');

        $this->container->singleton('idlikethis_Texts_ProviderInterface', 'idlikethis_Texts_Provider');

        $smarty = new Smarty();
        $smarty->setTemplateDir($templates_dir);
        $smarty->setCacheDir($templates_dir . '_cache');
        $this->container->singleton('Smarty', $smarty);

        $this->container->singleton('idlikethis_Templates_RenderEngineInterface', 'idlikethis_Adapters_SmartyAdapter');
        $this->container->bind('idlikethis_Shortcodes_ShortcodeInterface', 'idlikethis_Shortcodes_Simple');
        $this->container->bind('idlikethis_Contexts_ShortcodeContextInterface', 'idlikethis_Contexts_ShortcodeContext');

        $simple_shortcode = $this->container->resolve('idlikethis_Shortcodes_ShortcodeInterface');

        add_shortcode($simple_shortcode->get_tag(), array($simple_shortcode, 'render'));
    }

    /**
     * Binds and sets up implementations at boot time.
     */
    public function boot()
    {
        // TODO: Implement boot() method.
    }
}