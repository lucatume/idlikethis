<?php

interface idlikethis_Endpoints_HandlerInterface
{
    /**
     * Handles a request.
     *
     * @return bool `true` if the request was successfully handled, `false` otherwise.
     */
    public function handle(WP_REST_Request $request);
}