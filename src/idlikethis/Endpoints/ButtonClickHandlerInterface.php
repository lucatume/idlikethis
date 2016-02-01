<?php

interface idlikethis_Endpoints_ButtonClickHandlerInterface extends idlikethis_Endpoints_HandlerInterface
{
    /**
     * Handles a button click request.
     *
     * @return bool `true` if the request was successfully handled, `false` otherwise.
     */
    public function handle();
}