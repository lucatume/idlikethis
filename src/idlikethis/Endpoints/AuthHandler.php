<?php

class idlikethis_Endpoints_AuthHandler implements idlikethis_Endpoints_AuthHandlerInterface
{

    /**
     * Verifies an action is authorized.
     *
     * @param array $data An array of data that should store the authorization method.
     * @param string $action The action the auth refers to.
     * @return bool
     */
    public function verify_auth(array $data, $action)
    {
        return wp_verify_nonce($data['auth'], $action);
    }
}