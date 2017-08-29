<?php

class idlikethis_Endpoints_CleanShortcodesHandler implements idlikethis_Endpoints_CleanShortcodesHandlerInterface {

	/**
	 * @var \idlikethis_Shortcodes_CleanerInterface
	 */
	protected $cleaner;

	public function __construct(idlikethis_Shortcodes_CleanerInterface $cleaner) {
		$this->cleaner = $cleaner;
	}

	/**
	 * Handles a request.
	 *
	 * @return bool `true` if the request was successfully handled, `false` otherwise.
	 */
	public function handle(WP_REST_Request $request) {
		if (!current_user_can('install_plugins')) {
			return false;
		}

		return $this->cleaner->clean_all();
	}
}