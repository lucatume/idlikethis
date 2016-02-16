<?php

class idlikethis_Texts_VotesMetaBoxTextProvider implements idlikethis_Texts_VotesMetaboxTextProviderInterface
{

    /**
     * @return string
     */
    public function get_empty_comments_text()
    {
        return __('Ouch! No votes on this yet. Niet. Zero.', 'idlikethis');
    }

    /**
     * @return string
     */
    public function get_comments_title_text()
    {
        return __('Here are the votes!', 'idlikethis');
    }
}