<?php

class idlikethis_Texts_ShortcodeTextProvider implements idlikethis_Texts_ShortcodeTextProviderInterface
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