<?php

namespace rest;

class ButtonClickPostRequestCest {

	/**
	 * @test
	 * it should not insert any comment if post ID is missing from POST request
	 */
	public function it_should_not_insert_any_comment_if_post_id_is_missing_from_post_request( \FunctionalTester $I ) {
		$I->amOnPage( '/' );
		$wp_rest_nonce = $I->grabValueFrom( 'input[name="rest_nonce"]' );
		$I->haveHttpHeader( 'X-WP-Nonce', $wp_rest_nonce );
		$I->sendAjaxPostRequest( '/wp-json/idlikethis/v1/button-click', [
			'content' => 'Some content'
		] );
		$I->dontSeeCommentInDatabase( [ 'comment_content' => 'Some content' ] );
	}

	/**
	 * @test
	 * it should not insert any comment if post ID is not a valid post ID
	 */
	public function it_should_not_insert_any_comment_if_post_id_is_not_a_valid_post_id( \FunctionalTester $I ) {
		$I->amOnPage( '/' );
		$wp_rest_nonce = $I->grabValueFrom( 'input[name="rest_nonce"]' );
		$I->haveHttpHeader( 'X-WP-Nonce', $wp_rest_nonce );
		$I->sendAjaxPostRequest( '/wp-json/idlikethis/v1/button-click', [
			'content' => 'Some content',
			'post_id' => 2233
		] );

		$I->dontSeeCommentInDatabase( [ 'comment_content' => 'Some content' ] );
	}

	/**
	 * @test
	 * it should not insert any comment if content is missing from POST request
	 */
	public function it_should_not_insert_any_comment_if_content_is_missing_from_post_request( \FunctionalTester $I ) {
		$post_id = $I->havePostInDatabase( [ 'post_title' => 'Some post' ] );

		$I->amOnPage( '/' );
		$wp_rest_nonce = $I->grabValueFrom( 'input[name="rest_nonce"]' );
		$I->haveHttpHeader( 'X-WP-Nonce', $wp_rest_nonce );
		$I->sendAjaxPostRequest( '/wp-json/idlikethis/v1/button-click', [
			'post_id' => $post_id
		] );

		$I->dontSeeCommentInDatabase( [ 'comment_content' => 'Some content' ] );
	}

	/**
	 * @test
	 * it should insert a comment when hitting the endpoint with valid params
	 */
	public function it_should_insert_a_comment_when_hitting_the_endpoint_with_valid_params( \FunctionalTester $I ) {
		$post_id = $I->havePostInDatabase( [ 'post_title' => 'Some post' ] );

		$I->amOnPage( '/' );
		$wp_rest_nonce = $I->grabValueFrom( 'input[name="rest_nonce"]' );
		$I->haveHttpHeader( 'X-WP-Nonce', $wp_rest_nonce );

		$I->sendAjaxPostRequest( '/wp-json/idlikethis/v1/button-click', [
			'post_id' => $post_id,
			'content' => 'Some Content'
		] );

		$I->seeResponseCodeIs( 200 );
		$I->seeCommentInDatabase( [ 'comment_post_ID' => $post_id ] );
	}
}
