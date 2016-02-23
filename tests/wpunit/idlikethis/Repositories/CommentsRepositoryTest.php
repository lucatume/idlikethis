<?php
namespace idlikethis\Repositories;

use idlikethis_Repositories_CommentsRepository as CommentsRepository;

class CommentsRepositoryTest extends \Codeception\TestCase\WPTestCase {

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
		$this->assertInstanceOf( 'idlikethis_Repositories_CommentsRepository', $this->make_instance() );
	}

	/**
	 * @test
	 * it should return false if trying to add a comment to a non existing post
	 */
	public function it_should_return_false_if_trying_to_add_a_comment_to_a_non_existing_post() {
		$sut = $this->make_instance();

		$out = $sut->add_vote_for_post( 215, 'some content' );

		$this->assertFalse( $out );
	}

	/**
	 * @test
	 * it should return false if trying to add a commment without content
	 */
	public function it_should_return_false_if_trying_to_add_a_commment_without_content() {
		$sut = $this->make_instance();

		$post_id = $this->factory()->post->create( [ 'post_type' => 'post' ] );
		$out     = $sut->add_vote_for_post( $post_id, '' );

		$this->assertFalse( $out );
	}

	/**
	 * @test
	 * it should return the comment number id when adding a comment to a post
	 */
	public function it_should_return_the_comment_number_id_when_adding_a_comment_to_a_post() {
		$sut = $this->make_instance();

		$post_id = $this->factory()->post->create( [ 'post_type' => 'post' ] );
		$out     = $sut->add_vote_for_post( $post_id, 'some-comment' );

		$comments = get_comments( [ 'post_id' => $post_id ] );
		$comment  = reset( $comments );

		$this->assertEquals( $comment->comment_ID, $out );
	}

	/**
	 * @test
	 * it should set the comment user to the current user
	 */
	public function it_should_set_the_comment_user_to_the_current_user() {
		$sut     = $this->make_instance();
		$user_id = get_current_user_id();

		$post_id = $this->factory()->post->create( [ 'post_type' => 'post' ] );
		$out     = $sut->add_vote_for_post( $post_id, 'some-comment' );

		$comments = get_comments( [ 'post_id' => $post_id ] );
		$comment  = reset( $comments );


		$this->assertEquals( $user_id, $comment->user_id, $out );
	}

	/**
	 * @test
	 * it should throw if trying to get comments of non post
	 */
	public function it_should_throw_if_trying_to_get_comments_of_non_post() {
		$post_id = 123;

		$this->setExpectedException( 'InvalidArgumentException' );

		$sut = $this->make_instance();
		$sut->get_votes_for_post( get_post( $post_id ) );
	}

	/**
	 * @test
	 * it should return empty array if post has no comments associated to it
	 */
	public function it_should_return_empty_array_if_post_has_no_comments_associated_to_it() {
		$post_id = $this->factory()->post->create();

		$sut = $this->make_instance();
		$out = $sut->get_votes_for_post( get_post( $post_id ) );

		$this->assertEquals( [ ], $out );
	}

	/**
	 * @test
	 * it should return empty array if post has no idlikethis comments associated to it
	 */
	public function it_should_return_empty_array_if_post_has_no_idlikethis_comments_associated_to_it() {
		$post_id  = $this->factory()->post->create();
		$comments = $this->factory()->comment->create_many( 5, [ 'comment_post_ID' => $post_id ] );

		$sut = $this->make_instance();
		$out = $sut->get_votes_for_post( get_post( $post_id ) );

		$this->assertEquals( [ ], $out );
	}

	/**
	 * @test
	 * it should return array of texts to comments IDs when post has comments associated to it
	 */
	public function it_should_return_array_of_texts_to_comments_i_ds_when_post_has_comments_associated_to_it() {
		$post_id  = $this->factory()->post->create();
		$comments = [ ];
		array_map( function ( $count ) use ( &$comments, $post_id ) {
			$comment_data = [
				'comment_post_ID' => $post_id,
				'comment_type'    => 'idlikethis',
				'comment_content' => $count . ' - first idea'
			];
			$comments[]   = $this->factory()->comment->create( $comment_data );
		},
			range( 0, 4 ) );

		$sut = $this->make_instance();
		$out = $sut->get_votes_for_post( get_post( $post_id ) );

		$this->assertCount( 1, $out );
		$this->assertArrayHasKey( 'first idea', $out );
		$this->assertCount( 5, $out['first idea'] );
		$this->assertEquals( sort( $comments ), sort( $out['first idea'] ) );
	}

	/**
	 * @test
	 * it should return array of multiple text comment IDs when post has more than one idea associated to it
	 */
	public function it_should_return_array_of_multiple_text_comment_i_ds_when_post_has_more_than_one_idea_associated_to_it() {
		$post_id  = $this->factory()->post->create();
		$comments = [ ];
		$ideas    = [ 'first idea', 'second idea', 'third idea' ];
		foreach ( $ideas as $idea ) {
			$comments[ $idea ] = [ ];
			array_map( function ( $count ) use ( &$comments, $post_id, $idea ) {
				$comment_data        = [
					'comment_post_ID' => $post_id,
					'comment_type'    => 'idlikethis',
					'comment_content' => $count . ' - ' . $idea
				];
				$comments[ $idea ][] = $this->factory()->comment->create( $comment_data );
			},
				range( 0, 4 ) );
		}

		$sut = $this->make_instance();
		$out = $sut->get_votes_for_post( get_post( $post_id ) );

		$this->assertCount( 3, $out );

		foreach ( $ideas as $idea ) {
			$this->assertArrayHasKey( $idea, $out );
			$this->assertCount( 5, $out[ $idea ] );
			$this->assertEquals( sort( $comments[ $idea ] ), sort( $out[ $idea ] ) );
		}
	}

	/**
	 * @test
	 * it should store and retrieve comments based on idea text no matter the encoding
	 */
	public function it_should_store_and_retrieve_comments_based_on_idea_text_no_matter_the_encoding() {
		$sut = $this->make_instance();

		$post_id = $this->factory()->post->create();
		$idea    = 'new & revolutionary <> |\/ idea!';

		array_map( function ( $count ) use ( $post_id, $idea ) {
			$content      = esc_attr( $count . ' - ' . $idea );
			$comment_data = [
				'comment_post_ID' => $post_id,
				'comment_type'    => 'idlikethis',
				'comment_content' => $content
			];
			$this->factory()->comment->create( $comment_data );
		},
			range( 0, 2 ) );

		$out = $sut->get_votes_for_post( get_post( $post_id ) );

		$this->assertCount( 1, $out );
		$this->assertArrayHasKey( $idea, $out );
		$this->assertCount( 3, $out[ $idea ] );
	}

	/**
	 * @test
	 * it should handle the fast commenting exception
	 */
	public function it_should_handle_the_fast_commenting_exception() {
		$sut = $this->make_instance();

		$post_id = $this->factory()->post->create();

		$sut->add_vote_for_post( $post_id, 'some text' );
		$sut->add_vote_for_post( $post_id, 'some text' );
		$sut->add_vote_for_post( $post_id, 'some text' );
	}

	/**
	 * @test
	 * it should return false if trying to reset all comments on a non existing post
	 */
	public function it_should_return_false_if_trying_to_reset_all_comments_on_a_non_existing_post() {
		$sut = $this->make_instance();

		$out = $sut->reset_votes_for_post( 3344 );

		$this->assertFalse( $out );
	}

	/**
	 * @test
	 * it should delete all comments associated to a post when resetting
	 */
	public function it_should_delete_all_comments_associated_to_a_post_when_resetting() {
		$sut = $this->make_instance();

		$post_id = $this->factory()->post->create();
		$this->factory()->comment->create_many( 5,
			$comment_data = [ 'comment_post_ID' => $post_id, 'comment_type' => 'idlikethis' ] );

		$out = $sut->reset_votes_for_post( $post_id );

		$this->assertEquals( 5, $out );
	}

	/**
	 * @test
	 * it should not delete not idlikethis comments when resetting
	 */
	public function it_should_not_delete_not_idlikethis_comments_when_resetting() {
		$sut = $this->make_instance();

		$post_id = $this->factory()->post->create();
		$this->factory()->comment->create_many( 5,
			$comment_data = [ 'comment_post_ID' => $post_id, 'comment_type' => 'idlikethis' ] );
		$comment_ids = $this->factory()->comment->create_many( 5,
			$comment_data = [ 'comment_post_ID' => $post_id, 'comment_type' => 'not-idlikethis' ] );

		$out = $sut->reset_votes_for_post( $post_id );

		$this->assertEquals( 5, $out );
		foreach ( $comment_ids as $comment_id ) {
			$this->assertNotEmpty( get_comment( $comment_id ) );
		}
	}

	/**
	 * @test
	 * it should return false if trying to consolidate votes on non existing post
	 */
	public function it_should_return_false_if_trying_to_consolidate_votes_on_non_existing_post() {
		$post_id = 223344;

		$sut = $this->make_instance();
		$out = $sut->consolidate_votes_for_post( $post_id );

		$this->assertFalse( $out );
	}

	/**
	 * @test
	 * it should delete all comments when consolidating
	 */
	public function it_should_delete_all_comments_when_consolidating() {
		$post_id = $this->factory()->post->create();
		$this->factory()->comment->create_many( 5,
			$comment_data = [ 'comment_post_ID' => $post_id, 'comment_type' => 'idlikethis' ] );

		$sut = $this->make_instance();
		$out = $sut->consolidate_votes_for_post( $post_id );

		$this->assertTrue( $out );
		$this->assertCount( 0, get_comments( [ 'post_id' => $post_id, 'type' => 'idlikethis' ] ) );
	}

	/**
	 * @test
	 * it should not delete non idlikethis comments on post when consolidating
	 */
	public function it_should_not_delete_non_idlikethis_comments_on_post_when_consolidating() {
		$post_id = $this->factory()->post->create();
		$this->factory()->comment->create_many( 5,
			$comment_data = [ 'comment_post_ID' => $post_id, 'comment_type' => 'idlikethis' ] );
		$this->factory()->comment->create_many( 5,
			$comment_data = [ 'comment_post_ID' => $post_id, 'comment_type' => 'not-idlikethis' ] );

		$sut = $this->make_instance();
		$out = $sut->consolidate_votes_for_post( $post_id );

		$this->assertTrue( $out );
		$this->assertCount( 0, get_comments( [ 'post_id' => $post_id, 'type' => 'idlikethis' ] ) );
		$this->assertCount( 5, get_comments( [ 'post_id' => $post_id ] ) );
	}

	/**
	 * @test
	 * it should set consolidated votes meta on a post when consolidating comments
	 */
	public function it_should_set_consolidated_votes_meta_on_a_post_when_consolidating_comments() {
		$post_id = $this->factory()->post->create();
		$ideas   = [ 'idea one', 'idea two', 'idea three' ];
		foreach ( $ideas as $idea ) {
			for ( $i = 0; $i < 5; $i ++ ) {
				$this->factory()->comment->create( [
					'comment_post_ID' => $post_id,
					'comment_type'    => 'idlikethis',
					'comment_content' => $i . ' - ' . $idea
				] );
			}
		}

		$sut = $this->make_instance();
		$out = $sut->consolidate_votes_for_post( $post_id );

		$this->assertTrue( $out );
		$votes_meta = get_post_meta( $post_id, '_idlikethis_votes', true );
		$this->assertNotEmpty( $votes_meta );
		$this->assertInternalType( 'array', $votes_meta );
		$this->assertCount( 3, $votes_meta );
		foreach ( $ideas as $idea ) {
			$this->assertArrayHasKey( $idea, $votes_meta );
			$this->assertEquals( 5, $votes_meta[ $idea ] );
		}
	}

	/**
	 * @test
	 * it should consolidated votes in an empty array when consolidating comments on post with no comments
	 */
	public function it_should_consolidated_votes_in_an_empty_array_when_consolidating_comments_on_post_with_no_comments() {
		$post_id = $this->factory()->post->create();

		$sut = $this->make_instance();
		$out = $sut->consolidate_votes_for_post( $post_id );

		$this->assertTrue( $out );
		$votes_meta = get_post_meta( $post_id, '_idlikethis_votes', true );
		$this->assertEquals( array(), $votes_meta );
	}

	/**
	 * @test
	 * it should consolidate votes preserving ideas and count relations
	 */
	public function it_should_consolidate_votes_preserving_ideas_and_count_relations() {
		$post_id = $this->factory()->post->create();
		for ( $i = 0; $i < 10; $i ++ ) {
			$this->factory()->comment->create( [
				'comment_post_ID' => $post_id,
				'comment_type'    => 'idlikethis',
				'comment_content' => $i . ' - ' . 'idea one'
			] );
		}

		for ( $i = 0; $i < 23; $i ++ ) {
			$this->factory()->comment->create( [
				'comment_post_ID' => $post_id,
				'comment_type'    => 'idlikethis',
				'comment_content' => $i . ' - ' . 'idea two'
			] );
		}

		for ( $i = 0; $i < 3; $i ++ ) {
			$this->factory()->comment->create( [
				'comment_post_ID' => $post_id,
				'comment_type'    => 'idlikethis',
				'comment_content' => $i . ' - ' . 'idea three'
			] );
		}

		$sut = $this->make_instance();
		$out = $sut->consolidate_votes_for_post( $post_id );

		$this->assertTrue( $out );
		$votes_meta = get_post_meta( $post_id, '_idlikethis_votes', true );
		$this->assertNotEmpty( $votes_meta );
		$this->assertInternalType( 'array', $votes_meta );
		$this->assertCount( 3, $votes_meta );

		$this->assertArrayHasKey( 'idea one', $votes_meta );
		$this->assertArrayHasKey( 'idea two', $votes_meta );
		$this->assertArrayHasKey( 'idea three', $votes_meta );

		$this->assertEquals( 10, $votes_meta['idea one'] );
		$this->assertEquals( 23, $votes_meta['idea two'] );
		$this->assertEquals( 3, $votes_meta['idea three'] );
	}

	/**
	 * @test
	 * it should return consolidated and non consolidated total votes for a post
	 */
	public function it_should_return_consolidated_and_non_consolidated_total_votes_for_a_post() {
		$post_id = $this->factory()->post->create();
		for ( $i = 0; $i < 10; $i ++ ) {
			$this->factory()->comment->create( [
				'comment_post_ID' => $post_id,
				'comment_type'    => 'idlikethis',
				'comment_content' => $i . ' - ' . 'idea one'
			] );
		}

		for ( $i = 0; $i < 23; $i ++ ) {
			$this->factory()->comment->create( [
				'comment_post_ID' => $post_id,
				'comment_type'    => 'idlikethis',
				'comment_content' => $i . ' - ' . 'idea two'
			] );
		}

		$sut = $this->make_instance();
		$out = $sut->consolidate_votes_for_post( $post_id );

		for ( $i = 0; $i < 10; $i ++ ) {
			$this->factory()->comment->create( [
				'comment_post_ID' => $post_id,
				'comment_type'    => 'idlikethis',
				'comment_content' => $i . ' - ' . 'idea one'
			] );
		}

		for ( $i = 0; $i < 10; $i ++ ) {
			$this->factory()->comment->create( [
				'comment_post_ID' => $post_id,
				'comment_type'    => 'idlikethis',
				'comment_content' => $i . ' - ' . 'idea two'
			] );
		}

		$votes = $sut->get_votes_for_post( get_post( $post_id ) );

		$this->assertCount( 2, $votes );
		$this->assertArrayHasKey( 'idea one', $votes );
		$this->assertArrayHasKey( 'idea two', $votes );
		$this->assertCount( 20, $votes['idea one'] );
		$this->assertCount( 33, $votes['idea two'] );
	}


	private function make_instance() {
		return new CommentsRepository();
	}

}