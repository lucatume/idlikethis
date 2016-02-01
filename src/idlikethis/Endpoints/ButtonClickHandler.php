<?php

class idlikethis_Endpoints_ButtonClickHandler implements idlikethis_Endpoints_ButtonClickHandlerInterface
{

    /**
     * Handles a button click request.
     *
     * @return bool `true` if the request was successfully handled, `false` otherwise.
     */
    public function handle()
    {
        $data = $_POST;

        $response = new WP_REST_Response($data);

        return $response;
    }
}