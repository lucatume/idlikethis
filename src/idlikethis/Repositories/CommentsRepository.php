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
        if (empty(get_post($post_id))) {
            return false;
        }

        if (empty($content)) {
            return false;
        }

        $comments = get_comments(array(
            'comment_post_ID' => $post_id,
            'comment_type' => 'idlikethis',
        ));

        $comment_data = array(
            'comment_post_ID' => $post_id,
            'comment_author' => 'Anonymous',
            'comment_author_url' => get_post_permalink($post_id),
            'comment_author_email' => 'idlikethis@' . home_url(),
            'comment_content' => count($comments) . ' - ' . $content,
            'comment_type' => 'idlikethis',
            'user_id' => get_current_user_id(),
        );

        return wp_new_comment($comment_data);
    }
}