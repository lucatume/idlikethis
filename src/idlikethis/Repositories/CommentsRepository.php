<?php


/**
 * Class idlikethis_Repositories_CommentsRepository
 */
class idlikethis_Repositories_CommentsRepository implements idlikethis_Repositories_VotesRepositoryInterface {

	protected $consolidated_votes_meta_key = '_idlikethis_votes';

	/**
	 * Inserts a comment in the database for a given post.
	 *
	 * @param int    $post_id
	 * @param string $content
	 *
	 * @return false|int Either the inserted comment `comment_id` or `false` on failure.
	 */
	public function add_vote_for_post( $post_id, $content ) {
		if ( empty( get_post( $post_id ) ) ) {
			return false;
		}

		if ( empty( $content ) ) {
			return false;
		}

		$comments = $this->get_post_comments( $post_id );

		$comment_data = array(
			'comment_post_ID'      => $post_id,
			'comment_author'       => 'Anonymous',
			'comment_author_url'   => get_post_permalink( $post_id ),
			'comment_author_email' => 'idlikethis@' . home_url(),
			'comment_content'      => count( $comments ) . ' - ' . $content,
			'comment_type'         => 'idlikethis',
			'user_id'              => get_current_user_id(),
			'comment_approved'     => 1,
		);

		try {
			return wp_new_comment( $comment_data );
		} catch ( WPDieException $e ) {
			return false;
		}
	}

	/**
	 * Gets the idlikethis comments for the post in an associative array of comment text to comments.
	 *
	 * @param int|string|WP_Post $post
	 *
	 * @return bool|array An array of idlikethis comments for the post or `false` if the post is invalid.
	 */
	public function get_votes_for_post( $post ) {
		if ( ! get_post( $post ) ) {
			throw new InvalidArgumentException( 'Post ID must be a valid post ID or WP_Post object' );
		}

		$consolidated_votes = get_post_meta( $post->ID, $this->consolidated_votes_meta_key, true );
		if ( $consolidated_votes === '' ) {
			$results = $this->get_non_consolidated_votes_for_post( $post->ID );
		} else {
			array_walk( $consolidated_votes, array( $this, 'fill_votes' ) );
			$non_consolidated_votes_for_post = $this->get_non_consolidated_votes_for_post( $post->ID );
			$results                         = array_merge_recursive( $consolidated_votes, $non_consolidated_votes_for_post );
		}

		return $results;
	}

	/**
	 * @param $post_id
	 *
	 * @return array|int
	 */
	protected function get_post_comments( $post_id ) {
		return get_comments( array(
			'comment_post_ID' => $post_id,
			'comment_type'    => 'idlikethis',
		) );
	}

	protected function get_idea_text( $text ) {
		$matches = array();
		$pattern = '/^\\d{1,}\\s-\\s(.*)$/';
		$match   = preg_match( $pattern, $text, $matches );

		return $match ? $matches[1] : false;
	}

	private function add_comment_text( &$comment ) {
		$comment->idlikethis_text = wp_specialchars_decode( $this->get_idea_text( $comment->comment_content ) );
	}

	/**
	 * Resets the comments associated to a post.
	 *
	 * @param int $post_id
	 *
	 * @return bool True on success or false on failure.
	 */
	public function reset_votes_for_post( $post_id ) {
		if ( empty( get_post( $post_id ) ) ) {
			return false;
		}
		$count    = 0;
		$comments = get_comments( [ 'post_id' => $post_id, 'type' => 'idlikethis' ] );
		foreach ( $comments as $comment ) {
			wp_delete_comment( $comment, true );
			$count += 1;
		}

		return $count;
	}

	/**
	 * Consolidates the votes for a post.
	 *
	 * @param $post_id
	 *
	 * @return bool True on succes or false on failure
	 */
	public function consolidate_votes_for_post( $post_id ) {
		if ( empty( get_post( $post_id ) ) ) {
			return false;
		}

		$votes    = array();
		$comments = get_comments( [ 'post_id' => $post_id, 'type' => 'idlikethis' ] );
		/** @var WP_Comment $comment */
		foreach ( $comments as $comment ) {
			$text = $this->get_idea_text( $comment->comment_content );
			if ( isset( $votes[ $text ] ) ) {
				$votes[ $text ] += 1;
			} else {
				$votes[ $text ] = 1;
			}
			wp_delete_comment( $comment, true );
		}

		update_post_meta( $post_id, $this->consolidated_votes_meta_key, $votes );

		return true;
	}

	private function fill_votes( &$value, $index ) {
		$value = array_fill( 1, $value, 'consolidated_vote' );
	}

	private function get_non_consolidated_votes_for_post( $post_id ) {
		$post_comments = $this->get_post_comments( $post_id );

		$results = array();

		if ( empty( $post_comments ) ) {
			return $results;
		}

		array_walk( $post_comments, array( $this, 'add_comment_text' ) );

		foreach ( $post_comments as $comment ) {
			if ( $comment->idlikethis_text ) {
				if ( ! isset( $results[ $comment->idlikethis_text ] ) ) {
					$results[ $comment->idlikethis_text ] = array();
				}
				$results[ $comment->idlikethis_text ][] = $comment->comment_ID;
			}
		}

		return $results;
	}
}