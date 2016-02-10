<?php

class idlikethis_Shortcodes_UserContentShortcode extends idlikethis_Shortcodes_Simple
{
    protected function get_comment_text($attributes = array(), $content = '')
    {
        $content = empty($content) ? $this->context->get_comment_text() : $content;

        return esc_attr($content);
    }

}