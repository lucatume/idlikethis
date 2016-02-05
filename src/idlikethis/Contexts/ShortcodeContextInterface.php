<?php

interface idlikethis_Contexts_ShortcodeContextInterface extends idlikethis_Contexts_ContextInterface
{
    /**
     * @return string
     */
    public function get_comment_text();

    /**
     * @return int
     */
    public function get_post_id();
}