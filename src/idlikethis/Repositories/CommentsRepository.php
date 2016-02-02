<?php

class idlikethis_Repositories_CommentsRepository implements idlikethis_Repositories_CommentsRepositoryInterface
{

    /**
     * Inserts a comment in the database for a given post.
     *
     * @param int $post_id
     * @param string $content
     * @return false|int Either the inserted comment `comment_id` or `false` on failure.
     */
    public function add_for_post($post_id, $content)
    {
        global $current_user;

        $comment_data = array(
            'comment_post_ID' => $post_id,
            'comment_author' => 'Anonymous',
            'comment_content' => $content,
            'comment_type' => 'idlikethis',
            'user_id' => $current_user->ID,
        );

        return wp_new_comment($comment_data);
    }
}