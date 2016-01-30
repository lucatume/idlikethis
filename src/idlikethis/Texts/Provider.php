<?php

class idlikethis_Texts_Provider implements idlikethis_Texts_ProviderInterface
{

    /**
     * Returns the localized version of the button text.
     *
     * @return string
     */
    public function get_button_text()
    {
        return __("I'd like this", 'idlikethis');
    }
}