<?php

/**
 * Class idlikethis_Repositories_CommentsRepository
 */
class idlikethis_Repositories_CommentsRepository implements idlikethis_Repositories_VotesRepositoryInterface
{

    /**
     * Inserts a comment in the database for a given post.
     *
     * @param int $post_id
     * @param string $content
     * @return false|int Either the inserted comment `comment_id` or `false` on failure.
     */
    public function add_vote_for_post($post_id, $content)
    {
        if (empty(get_post($post_id))) {
            return false;
        }

        if (empty($content)) {
            return false;
        }

        $comments = $this->get_post_comments($post_id);

        $comment_data = array(
            'comment_post_ID' => $post_id,
            'comment_author' => 'Anonymous',
            'comment_author_url' => get_post_permalink($post_id),
            'comment_author_email' => 'idlikethis@' . home_url(),
            'comment_content' => count($comments) . ' - ' . $content,
            'comment_type' => 'idlikethis',
            'user_id' => get_current_user_id(),
            'comment_approved' => 1,
        );

        try {
            return wp_new_comment($comment_data);
        } catch (WPDieException $e) {
            return false;
        }
    }

    /**
     * Gets the idlikethis comments for the post in an associative array of comment text to comments.
     *
     * @param int|string|WP_Post $post_id
     * @return bool|array An array of idlikethis comments for the post or `false` if the post is invalid.
     */
    public function get_votes_for_post($post_id)
    {
        if (!get_post($post_id)) {
            throw new InvalidArgumentException('Post ID must be a valid post ID or WP_Post object');
        }

        $post_comments = $this->get_post_comments($post_id);

        $results = array();

        if (empty($post_comments)) {
            return $results;
        }

        array_walk($post_comments, array($this, 'add_comment_text'));

        foreach ($post_comments as $comment) {
            if ($comment->idlikethis_text) {
                if (!isset($results[$comment->idlikethis_text])) {
                    $results[$comment->idlikethis_text] = array();
                }
                $results[$comment->idlikethis_text][] = $comment->comment_ID;
            }
        }

        return $results;
    }

    /**
     * @param $post_id
     * @return array|int
     */
    protected function get_post_comments($post_id)
    {
        return get_comments(array(
            'comment_post_ID' => $post_id,
            'comment_type' => 'idlikethis',
        ));
    }

    protected function get_idea_text($text)
    {
        $matches = array();
        $pattern = '/^\\d{1,}\\s-\\s(.*)$/';
        $match = preg_match($pattern, $text, $matches);
        return $match ? $matches[1] : false;
    }

    private function add_comment_text(&$comment)
    {
        $comment->idlikethis_text = wp_specialchars_decode($this->get_idea_text($comment->comment_content));
    }

    /**
     * Resets the comments associated to a post.
     *
     * @param int $post_id
     * @return bool True on success or false on failure.
     */
    public function reset_votes_for_post($post_id)
    {
        if (empty(get_post($post_id))) {
            return false;
        }
        $count = 0;
        $comment_ids = get_comments(['post_id' => $post_id, 'type' => 'idlikethis']);
        foreach ($comment_ids as $comment_id) {
            wp_delete_comment($comment_id, true);
            $count += 1;
        }

        return $count;
    }
}