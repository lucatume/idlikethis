<?php

class idlikethis_Comments_TableContext implements idlikethis_Comments_TableContextInterface
{

    /**
     * Whether the current context is an admin comments edit screen or not.
     *
     * @return bool
     */
    public function is_comments_edit_screen()
    {
        if (!is_admin()) {
            return;
        }
        $current_screen = get_current_screen();
        return $current_screen && $current_screen->base == 'edit-comments';
    }
}