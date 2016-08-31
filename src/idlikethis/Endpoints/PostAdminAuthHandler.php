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
		return current_user_can('edit_posts');
	}

	public function supported_actions() {
		return array( 'consolidate-all', 'reset-all' );
	}
}