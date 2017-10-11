<?php

namespace acceptance\frontend;

class ShortcodeCest {

	public function _before( \AcceptanceTester $I ) {
		$I->loginAsAdmin();
		$I->amOnPluginsPage();
		$I->seePluginInstalled( 'id-like-this' );
		$I->seePluginActivated( 'id-like-this' );
	}

	/**
	 * @test
	 * it should render simple shortcode
	 */
	public function it_should_render_simple_shortcode( \AcceptanceTester $I ) {
		$content = 'Lorem ipsum [idlikethis]';
		$post_id = $I->havePostInDatabase( [ 'post_name' => 'foo', 'post_content' => $content ] );

		$I->amOnPage( '/?p=' . $post_id );

		$text = "I'd like this";
		$I->see('like this');
//		$I->seeElement( '.idlikethis-button[data-post-id="' . $post_id . '"][data-text="' . $text . '"] button' );
	}

	/**
	 * @test
	 * it should render extended shortcode
	 */
	public function it_should_render_extended_shortcode( \AcceptanceTester $I ) {
		$text    = 'Some idea of mine';
		$content = 'Lorem ipsum [idlikethis]' . $text . '[/idlikethis]';
		$post_id = $I->havePostInDatabase( [ 'post_name' => 'foo', 'post_content' => $content ] );

		$I->amOnPage( '/?p=' . $post_id );

		$I->seeElement( '.idlikethis-button[data-post-id="' . $post_id . '"][data-text="' . $text . '"] button' );
	}
}
