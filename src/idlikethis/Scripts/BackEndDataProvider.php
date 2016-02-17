<?php

class idlikethis_Scripts_BackEndDataProvider implements idlikethis_Scripts_BackEndDataProviderInterface
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
                'reset_all' => array(
                    'url' => home_url(rest_get_url_prefix() . '/idlikethis/v1/admin/reset-all/'),
                ),
                'consolidate_all' => array(
                    'url' => home_url(rest_get_url_prefix() . '/idlikethis/v1/admin/consolidate-all/'),
                ),
            )
        );
    }
}