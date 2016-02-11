<?php

interface idlikethis_Comments_TableFilterInterface
{

    /**
     * Sets some query var parameters on the comments query before comments are fetched.
     *
     * @param WP_Comment_Query $query
     * @return void
     */
    public function on_pre_get_comments(WP_Comment_Query $query);
}