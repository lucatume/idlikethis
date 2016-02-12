<?php

class idlikethis_MetaBoxes_VotesDisplayMetaBox implements idlikethis_MetaBoxes_VotesDisplayMetaBoxInterface
{

    /**
     * Returns the meta box id.
     *
     * @return string
     */
    public function id()
    {
        return 'idlikethis-vote-display';
    }

    /**
     * Returns the meta box title.
     *
     * @return string
     */
    public function title()
    {
        return __("I'd like to see the votes", 'idlikethis');
    }

    /**
     * Returns the screen(s) the meta box should display on.
     *
     * @return string|array|WP_Screen
     */
    public function screen()
    {
        return array('post', 'page');
    }

    /**
     * Returns the context the meta box should display into.
     *
     * @return string
     */
    public function context()
    {
        return 'side';
    }

    /**
     * Returns the priority for the meta box.
     *
     * @return string
     */
    public function priority()
    {
        return 'high';
    }

    /**
     * Echoes the meta box markup to the page.
     *
     * @param string|WP_Post|array $object
     * @param array|mixed $box The metabox registration description.
     * @return void
     */
    public function render($object, $box)
    {
        echo "<h3>Votes</h3>";
    }
}