<?php

interface idlikethis_Texts_VotesMetaBoxTextProviderInterface
{

    /**
     * @return string
     */
    public function get_empty_comments_text();

    /**
     * @return string
     */
    public function get_comments_title_text();
}