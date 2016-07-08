<?php

namespace rest;

use Helper\Functional;

class ConsolidateAllPostRequestCest {

	/**
	 * @test
	 * it should not consolidate comments if post id is missing from POST request
	 */
	public function it_should_not_consolidate_comments_if_post_id_is_missing_from_post_request( \FunctionalTester $I ) {
		$post_id     = $I->havePostInDatabase();
		$comment_ids = $I->haveManyCommentsInDatabase( 3, $post_id, [ 'comment_type' => 'idlikethis' ] );

		$I->loginAsAdmin();
		$I->amEditingPostWithId( $post_id );

		$wp_rest_nonce = $I->grabValueFrom( 'input[name="rest_nonce"]' );
		$I->haveHttpHeader( 'X-WP-Nonce', $wp_rest_nonce );

		$I->sendAjaxPostRequest( '/wp-json/idlikethis/v1/admin/consolidate-all', [
		] );

		$I->seeResponseCodeIs( 400 );
		foreach ( $comment_ids as $comment_id ) {
			$I->seeCommentInDatabase( [ 'comment_ID' => $comment_id, 'comment_post_ID' => $post_id ] );
		}
	}

	/**
	 * @test
	 * it should not consolidate comments if current user cannot edit posts
	 */
	public function it_should_not_consolidate_comments_if_current_user_cannot_edit_posts( \FunctionalTester $I ) {
		$I->haveUserInDatabase( 'someUser', 'subscriber', [ 'user_pass' => 'somePassword' ] );
		$I->loginAsAdmin();

		$post_id     = $I->havePostInDatabase();
		$comment_ids = $I->haveManyCommentsInDatabase( 3, $post_id, [ 'comment_type' => 'idlikethis' ] );

		$I->amEditingPostWithId( $post_id );

		// not sending headers hence the user will be set to a visitor and will not be able to edit posts

		$I->sendAjaxPostRequest( '/wp-json/idlikethis/v1/admin/consolidate-all', [
			'post_id' => $post_id
		] );

		$I->seeResponseCodeIs( 403 );
		foreach ( $comment_ids as $comment_id ) {
			$I->seeCommentInDatabase( [ 'comment_ID' => $comment_id, 'comment_post_ID' => $post_id ] );
		}
	}

	/**
	 * @test
	 * it should consolidate comments when post id is valid and user can edit posts
	 */
	public function it_should_consolidate_comments_when_post_id_is_valid_and_user_can_edit_posts( \FunctionalTester $I ) {
		$post_id = $I->havePostInDatabase();

		$comment_ids = $I->haveManyCommentsInDatabase( 3, $post_id, [ 'comment_type' => 'idlikethis', 'comment_content' => '{{n}} - foo' ] );

		$I->loginAsAdmin();
		$I->amEditingPostWithId( $post_id );

		$wp_rest_nonce = $I->grabValueFrom( 'input[name="rest_nonce"]' );
		$I->haveHttpHeader( 'X-WP-Nonce', $wp_rest_nonce );

		$I->sendAjaxPostRequest( '/wp-json/idlikethis/v1/admin/consolidate-all', [
			'post_id' => $post_id
		] );

		$I->seeResponseCodeIs( 200 );
		foreach ( $comment_ids as $comment_id ) {
			$I->dontSeeCommentInDatabase( [ 'comment_ID' => $comment_id, 'comment_post_ID' => $post_id ] );
		}
		$I->seePostMetaInDatabase( [ 'post_id' => $post_id, 'meta_key' => '_idlikethis_votes', 'meta_value' => serialize( [ 'foo' => 3 ] ) ] );
	}
}
