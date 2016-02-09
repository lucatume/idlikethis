<?php

class idlikethis_Endpoints_AuthHandler implements idlikethis_Endpoints_AuthHandlerInterface
{

    /**
     * @var string
     */
    protected $action;

    /**
     * @var int
     */
    protected $user_id;

    /**
     * Verifies an action is authorized.
     *
     * @param WP_REST_Request $request The request representation.
     * @param string $action The action the auth refers to.
     * @return bool
     */
    public function verify_auth(WP_REST_Request $request, $action)
    {
        // we are satisfied with the nonce verification the REST API will make
        return true;
    }
}
