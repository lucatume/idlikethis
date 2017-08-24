<?php

interface idlikethis_Repositories_PostRepositoryInterface {

	/**
	 * Returns an array of post IDs of posts that contain the plugin shortcodes.
	 *
	 * @return array
	 */
	public function get_posts_with_shortcodes();

	/**
	 * Returns the post content.
	 *
	 * @param int $post_id The post ID
	 *
	 * @return mixed
	 */
	public function get_post_content( $post_id );

	/**
	 * Updates a post content.
	 *
	 * @param int    $post_id      The post ID.
	 * @param string $post_content The new post content.
	 *
	 * @return mixed
	 */
	public function set_post_content( $post_id, $post_content );
}