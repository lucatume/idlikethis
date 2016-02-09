<?php

interface idlikethis_Endpoints_AuthHandlerInterface
{

    /**
     * Verifies an action is authorized.
     *
     * @param WP_REST_Request $request The request representation.
     * @param string $action The action the auth refers to.
     * @return bool
     */
    public function verify_auth(WP_REST_Request $request, $action);
}