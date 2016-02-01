<?php

interface idlikethis_Shortcodes_ShortcodeInterface
{
    /**
     * Returns the shortcode rendered markup code.
     *
     * @param string|array $attributes An array of shortcode attributes.
     * @param string $content The shortcode content.
     *
     * @return string
     */
    public function render($attributes = array(), $content = '');

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