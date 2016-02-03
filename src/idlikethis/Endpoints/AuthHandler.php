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
        if (!is_string($action)) {
            throw new InvalidArgumentException('Action must be a string');
        }

        if (empty($data['auth'])) {
            return false;
        }

        return (bool)wp_verify_nonce($data['auth'], $action);
    }
}