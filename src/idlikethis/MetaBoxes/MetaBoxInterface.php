<?php

interface idlikethis_MetaBoxes_MetaBoxInterface
{

    /**
     * Returns the meta box id.
     *
     * @return string
     */
    public function id();

    /**
     * Returns the meta box title.
     *
     * @return string
     */
    public function title();

    /**
     * Returns the screen(s) the meta box should display on.
     *
     * @return string|array|WP_Screen
     */
    public function screen();

    /**
     * Returns the context the meta box should display into.
     *
     * @return string
     */
    public function context();

    /**
     * Returns the priority for the meta box.
     *
     * @return string
     */
    public function priority();

    /**
     * Echoes the meta box markup to the page.
     *
     * @param string|WP_Post|array $object
     * @param array|mixed $box The meta box registration description.
     * @return void
     */
    public function render($object, $box);
}