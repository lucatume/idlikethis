<?php

class idlikethis_Texts_PostControlMetaBoxTextsProvider implements idlikethis_Texts_PostControlMetaBoxTextsProviderInterface
{

    /**
     * @return string
     */
    public function get_empty_comments_text()
    {
        return __('There are no votes. Nothing to control.', 'idlikethis');
    }

    /**
     * @return string
     */
    public function get_comments_title_text()
    {
        return __('Control freak...', 'idlikethis');
    }

    /**
     * @return string
     */
    public function get_reset_all_text()
    {
        return __('Reset all', 'idlikethis');
    }

    /**
     * @return string
     */
    public function get_consolidate_all_text()
    {
        return __('Consolidate all', 'idlikethis');
    }
}