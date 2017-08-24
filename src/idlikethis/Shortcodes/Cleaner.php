<?php

class idlikethis_Shortcodes_Cleaner implements idlikethis_Shortcodes_CleanerInterface {

	protected $shortcode_pattern = '#\\[idlikethis[^\\]]*\\].*\\[\\/idlikethis\\]|\\[idlikethis[^\\]]*\\]#uU';

	/**
	 * @var \idlikethis_Repositories_PostRepositoryInterface
	 */
	protected $repository;

	public function __construct( idlikethis_Repositories_PostRepositoryInterface $repository ) {
		$this->repository = $repository;
	}

	public function clean_all() {
		$to_clean = $this->repository->get_posts_with_shortcodes();

		foreach ( $to_clean as $post_id ) {
			$original_post_content = $this->repository->get_post_content( $post_id );
			$frags                 = preg_split( $this->shortcode_pattern, $original_post_content );
			$post_content          = implode( '', array_filter( $frags, array( $this, 'is_not_shortcode' ) ) );
			if ( $original_post_content !== $post_content ) {
				$this->repository->set_post_content( $post_id, $post_content );
			}
		}
	}

	protected function is_not_shortcode( $value ) {
		return ! preg_match( $this->shortcode_pattern, $value );
	}
}