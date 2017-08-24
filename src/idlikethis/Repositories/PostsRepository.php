<?php

class idlikethis_Repositories_PostsRepository implements idlikethis_Repositories_PostRepositoryInterface {

	/**
	 * Returns an array of post IDs of posts that contain the plugin shortcodes.
	 *
	 * @return array
	 */
	public function get_posts_with_shortcodes() {
		global $wpdb;

		$query = "SELECT ID FROM {$wpdb->posts} WHERE post_content LIKE '%[idlikethis]%'";
		$ids   = $wpdb->get_col( $query );

		return empty( $ids ) ? [] : $ids;
	}

	/**
	 * Returns the post content.
	 *
	 * @param int $post_id The post ID
	 *
	 * @return mixed
	 */
	public function get_post_content( $post_id ) {
		$post = get_post( $post_id );

		return $post ? $post->post_content : '';
	}

	/**
	 * Updates a post content.
	 *
	 * @param int    $post_id      The post ID.
	 * @param string $post_content The new post content.
	 *
	 * @return mixed
	 */
	public function set_post_content( $post_id, $post_content ) {
		return wp_update_post( array( 'ID' => $post_id, 'post_content' => $post_content ) );
	}
}