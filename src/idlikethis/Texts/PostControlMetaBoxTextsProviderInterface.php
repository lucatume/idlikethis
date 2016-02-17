<?php

interface idlikethis_Texts_PostControlMetaBoxTextsProviderInterface
{

    /**
     * @return string
     */
    public function get_empty_comments_text();

    /**
     * @return string
     */
    public function get_comments_title_text();

    /**
     * @return string
     */
    public function get_reset_all_text();

    /**
     * @return string
     */
    public function get_consolidate_all_text();
}