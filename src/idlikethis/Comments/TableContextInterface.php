<?php

interface idlikethis_Comments_TableContextInterface
{

    /**
     * Whether the current context is an admin comments edit screen or not.
     *
     * @return bool
     */
    public function is_comments_edit_screen();
}