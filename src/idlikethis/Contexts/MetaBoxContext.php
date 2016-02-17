<?php

class idlikethis_Contexts_MetaBoxContext implements idlikethis_Contexts_MetaBoxContextInterface
{

    /**
     * @return int
     */
    public function get_post_id()
    {
        global $post;
        $post = get_post($post);

        return $post ? $post->ID : null;
    }
}