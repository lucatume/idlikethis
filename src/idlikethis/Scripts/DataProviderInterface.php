<?php

interface idlikethis_Scripts_DataProviderInterface
{
    /**
     * Returns an array containing the data to be localized.
     *
     * @return array
     */
    public function get_data();
}