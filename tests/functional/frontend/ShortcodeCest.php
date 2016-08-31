<?php
namespace frontend;

class ShortcodeCest {

	/**
	 * @test
	 * it should render simple shortcode
	 */
	public function it_should_render_simple_shortcode( \FunctionalTester $I ) {
		$content = 'Lorem ipsum [idlikethis]';
		$post_id = $I->havePostInDatabase( [ 'post_title' => 'Some title', 'post_content' => $content ] );

		$I->amOnPage( '/' );
		$text = "I'd like this";
		$I->seeElement( '.idlikethis-button[data-post-id="' . $post_id . '"][data-text="' . $text . '"] button' );
	}

	/**
	 * @test
	 * it should render extended shortcode
	 */
	public function it_should_render_extended_shortcode( \FunctionalTester $I ) {
		$content = 'Lorem ipsum [idlikethis]Some idea of mine[/idlikethis]';
		$post_id = $I->havePostInDatabase( [ 'post_title' => 'Some title', 'post_content' => $content ] );

		$I->amOnPage( '/' );
		$text = "Some idea of mine";
		$I->seeElement( '.idlikethis-button[data-post-id="' . $post_id . '"][data-text="' . $text . '"] button' );
	}
}
