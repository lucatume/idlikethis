<?php


class idlikethis_Endpoints_PostAdminAuthHandler implements idlikethis_Endpoints_PostAdminAuthHandlerInterface {

	/**
	 * Verifies an action is authorized.
	 *
	 * @param WP_REST_Request $request The request representation.
	 * @param string          $action  The action the auth refers to.
	 *
	 * @return bool
	 */
	public function verify_auth( WP_REST_Request $request, $action ) {
		$post_id = $request->get_param( 'post_id' );
		if ( empty( $post_id ) ) {
			return false;
		}
		if ( empty( get_post( $post_id ) ) ) {
			return false;
		}
		if ( ! in_array( $action, $this->supported_actions() ) ) {
			return false;
		}

		return current_user_can( 'edit_post', $post_id );
	}

	public function supported_actions() {
		return array( 'consolidate-all', 'reset-all' );
	}
}