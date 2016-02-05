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
        return array(
            'endpoints' => array(
                'button-click' => array(
                    'url' => home_url('idlikethis/v1/button-click/'),
                    'nonce' => wp_create_nonce('button-click'),
                )
            )
        );
    }
}