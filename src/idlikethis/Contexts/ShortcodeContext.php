<?php

class idlikethis_Contexts_ShortcodeContext implements idlikethis_Contexts_ShortcodeContextInterface
{

    /**
     * @return string
     */
    public function get_comment_text()
    {
        return esc_attr(__("I'd like this", 'idlikehtis'));
    }

    /**
     * @return int
     */
    public function get_post_id()
    {
        return get_the_ID();
    }
}