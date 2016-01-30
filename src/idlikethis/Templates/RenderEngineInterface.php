<?php

interface idlikethis_Templates_RenderEngineInterface
{

    /**
     * Renders a template using the provided data.
     *
     * @param string $template_slug
     * @param array $data
     */
    public function render($template_slug, array $data = array());
}