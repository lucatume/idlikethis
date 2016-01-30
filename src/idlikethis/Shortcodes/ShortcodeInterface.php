<?php

interface idlikethis_Shortcodes_ShortcodeInterface
{
    /**
     * Returns the shortcode rendered markup code.
     *
     * @return string
     */
    public function render();

    /**
     * Returns the shortcode tag.
     *
     * @return string
     */
    public function get_tag();

    /**
     * @param $template_slug
     */
    public function set_template_slug($template_slug);

    /**
     * @param array $data
     */
    public function set_template_data(array $data);
}