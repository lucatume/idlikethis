<?php

class idlikethis_Adapters_SmartyAdapter implements idlikethis_Templates_RenderEngineInterface
{
    /**
     * @var Smarty
     */
    protected $smarty;

    /**
     * idlikethis_Adapters_SmartyAdapter constructor.
     * @param Smarty $smarty
     */
    public function __construct(Smarty $smarty)
    {
        $this->smarty = $smarty;
    }

    /**
     * Renders a template using the provided data.
     *
     * @param string $template_slug
     * @param array $data
     */
    public function render($template_slug, array $data = array())
    {
        if (!empty($data)) {
            array_walk($data, array($this, 'assign_template_var'));
        }
        $template_slug = preg_match('/\\.tpl$/', $template_slug) ? $template_slug : $template_slug . '.tpl';

        return $this->smarty->fetch($template_slug);
    }

    protected function assign_template_var($value, $key)
    {
        $this->smarty->assign($key, $value);
    }
}