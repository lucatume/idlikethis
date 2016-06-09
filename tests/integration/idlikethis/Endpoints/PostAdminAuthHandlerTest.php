<?php
namespace idlikethis\Endpoints;

use idlikethis_Endpoints_PostAdminAuthHandler as PostAdminHandler;

class PostAdminAuthHandlerTest extends \Codeception\TestCase\WPTestCase {

	public function setUp() {
		// before
		parent::setUp();

		// your set up methods here
	}

	public function tearDown() {
		// your tear down methods here

		// then
		parent::tearDown();
	}

	/**
	 * @test
	 * it should be instantiatable
	 */
	public function it_should_be_instantiatable() {
		$sut = $this->make_instance();

		$this->assertInstanceOf( 'idlikethis_Endpoints_PostAdminAuthHandler', $sut );
	}

	private function make_instance() {
		return new PostAdminHandler();
	}

	/**
	 * @test
	 * it should return false if current user cannot edit post
	 */
	public function it_should_return_false_if_current_user_cannot_edit_post() {
		$post_id = $this->factory()->post->create();
		wp_set_current_user( 0 );

		$sut               = $this->make_instance();
		$supported_actions = $sut->supported_actions();
		$request           = new \WP_REST_Request( 'create', '/some-path' );
		$request->set_param( 'post_id', $post_id );
		$out = $sut->verify_auth( $request, reset( $supported_actions ) );
		$this->assertFalse( $out );
	}

	/**
	 * @test
	 * it should return true if current user can edit post
	 */
	public function it_should_return_true_if_current_user_can_edit_post() {
		$post_id = $this->factory()->post->create();
		wp_set_current_user( 1 );

		$sut = $this->make_instance();

		$supported_actions = $sut->supported_actions();
		$request           = new \WP_REST_Request( 'create', '/some-path' );
		$request->set_param( 'post_id', $post_id );
		$out = $sut->verify_auth( $request, reset( $supported_actions ) );
		$this->assertTrue( $out );
	}
}