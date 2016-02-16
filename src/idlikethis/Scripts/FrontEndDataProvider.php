<?php

class idlikethis_Scripts_FrontEndDataProvider implements idlikethis_Scripts_FrontEndDataProviderInterface
{

    /**
     * Returns an array containing the data to be localized.
     *
     * @return array
     */
    public function get_data()
    {
        $nonce = wp_create_nonce('wp_rest');
        return array(
            'endpoints' => array(
                'domain' => home_url(),
                'nonce' => $nonce,
                'button_click' => array(
                    'url' => home_url(rest_get_url_prefix() . '/idlikethis/v1/button-click/'),
                )
            )
        );
    }
}