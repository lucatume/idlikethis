<?php

interface idlikethis_Repositories_CommentsRepositoryInterface
{

    /**
     * Inserts a comment in the database for a given post.
     *
     * @param int $post_id
     * @param string $content
     * @return false|int Either the inserted comment `comment_id` or `false` on failure.
     */
    public function add_for_post($post_id, $content);

    /**
     * Gets the idlikethis comments for the post in an associative array of comment text to comments.
     *
     * @param int|string|WP_Post $post_id
     * @return bool|array An array of idlikethis comments for the post or `false` if the post is invalid.
     */
    public function get_comments_for_post($post_id);

    /**
     * Resets the comments associated to a post.
     *
     * @param int $post_id
     * @return bool True on success or false on failure.
     */
    public function reset_comments_for_post($post_id);
}