<?php
namespace idlikethis\Endpoints;

use idlikethis_Endpoints_PostAdminAuthHandler as PostAdminHandler;
use tad\WPBrowser\Generators\Post;

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

	/**
	 * @test
	 * it should return false if post_id is not in request
	 */
	public function it_should_return_false_if_post_id_is_not_in_request() {
		wp_set_current_user( 0 );

		$sut = $this->make_instance();

		$supported_actions = $sut->supported_actions();
		$request           = new \WP_REST_Request( 'create', '/some-path' );
		$out               = $sut->verify_auth( $request, reset( $supported_actions ) );
		$this->assertFalse( $out );
	}

	/**
	 * @test
	 * it should return false if post_id is not existent
	 */
	public function it_should_return_false_if_post_id_is_not_existent() {
		$post_id = 4455;
		wp_set_current_user( 0 );

		$sut = $this->make_instance();

		$supported_actions = $sut->supported_actions();
		$request           = new \WP_REST_Request( 'create', '/some-path' );
		$request->set_param( 'post_id', $post_id );
		$out = $sut->verify_auth( $request, reset( $supported_actions ) );
		$this->assertFalse( $out );
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
	 * it should return false if action is not a supported one
	 */
	public function it_should_return_false_if_action_is_not_a_supported_one() {
		$post_id = $this->factory()->post->create();
		wp_set_current_user( 1 );

		$sut = $this->make_instance();

		$request = new \WP_REST_Request( 'create', '/some-path' );
		$request->set_param( 'post_id', $post_id );
		$out = $sut->verify_auth( $request, 'some-action' );
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

	private function make_instance() {
		return new PostAdminHandler();
	}
}