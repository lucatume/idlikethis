<?php

namespace idlikethis\Repositories;

use idlikethis_Repositories_PostsRepository as PostRepository;

class PostsRepositoryTest extends \Codeception\TestCase\WPTestCase {

	/**
	 * @test
	 * it should be instantiatable
	 */
	public function it_should_be_instantiatable() {
		$this->assertInstanceOf( 'idlikethis_Repositories_PostsRepository', $this->make_instance() );
	}

	private function make_instance() {
		return new PostRepository();
	}

	public function with_shortcodes_count() {
		return [
			[ 0, 0, 0 ],
			[ 1, 1, 1 ],
			[ 3, 0, 3 ],
			[ 0, 3, 0 ],
			[ 5, 5, 5 ],
		];
	}

	/**
	 * Test get_posts_with_shortcodes
	 *
	 * @dataProvider with_shortcodes_count
	 */
	public function test_get_posts_with_shortcodes( $with_count, $without_count, $expected_count ) {
		$with_shortcode = $this->factory()->post->create_many( $with_count, [ 'post_content' => 'Lorem dolor [idlikethis]' ] );
		$this->factory()->post->create_many( $without_count, [ 'post_content' => 'Lorem dolor' ] );

		$sut                  = $this->make_instance();
		$posts_with_shortcode = $sut->get_posts_with_shortcodes();

		$this->assertEqualSets( $with_shortcode, $posts_with_shortcode );
		$this->assertCount( $expected_count, $posts_with_shortcode );
	}

	/**
	 * It should allow gettin a post content
	 *
	 * @test
	 */
	public function should_allow_gettin_a_post_content() {
		$post_1 = $this->factory()->post->create( [ 'post_content' => 'Lorem dolor' ] );
		$post_2 = $this->factory()->post->create( [ 'post_content' => 'Lorem dolor ipsum' ] );
		$post_3 = $this->factory()->post->create( [ 'post_content' => '' ] );

		$sut = $this->make_instance();

		$this->assertEquals( 'Lorem dolor', $sut->get_post_content( $post_1 ) );
		$this->assertEquals( 'Lorem dolor ipsum', $sut->get_post_content( $post_2 ) );
		$this->assertEquals( '', $sut->get_post_content( $post_3 ) );
	}

	/**
	 * It should allow setting a post content
	 *
	 * @test
	 */
	public function should_allow_setting_a_post_content() {
		$post = $this->factory()->post->create( [ 'post_content' => 'Lorem dolor' ] );

		$sut = $this->make_instance();

		$sut->set_post_content( $post, 'Foo bar' );
		$this->assertEquals( 'Foo bar', get_post( $post )->post_content );
	}
}