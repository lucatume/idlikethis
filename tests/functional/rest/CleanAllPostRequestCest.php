<?php

namespace rest;

class CleanAllPostRequestCest {

	/**
	 * It should remove all shortcodes from posts
	 *
	 * @test
	 */
	public function should_remove_all_shortcodes_from_posts(\FunctionalTester $I) {
		$one   = $I->havePostInDatabase(['post_content' => 'lorem']);
		$two   = $I->havePostInDatabase(['post_content' => 'lorem[idlikethis]']);
		$three = $I->havePostInDatabase(['post_content' => 'lorem[idlikethis]foo[/idlikethis]']);

		$I->loginAsAdmin();
		$I->amOnAdminPage('/');
		$wp_rest_nonce = $I->grabValueFrom('input[name="rest_nonce"]');
		$I->haveHttpHeader('X-WP-Nonce', $wp_rest_nonce);
		$I->sendAjaxPostRequest('/wp-json/idlikethis/v1/admin/clean-all');

		$I->seePostInDatabase(['ID' => $one, 'post_content' => 'lorem']);
		$I->seePostInDatabase(['ID' => $two, 'post_content' => 'lorem']);
		$I->seePostInDatabase(['ID' => $three, 'post_content' => 'lorem']);
	}

	/**
	 * It should not allow users that cannot edit plugins to clean shortcodes
	 *
	 * @test
	 */
	public function should_not_allow_users_that_cannot_edit_plugins_to_clean_shortcodes(\FunctionalTester $I) {
		$one   = $I->havePostInDatabase(['post_content' => 'lorem']);
		$two   = $I->havePostInDatabase(['post_content' => 'lorem[idlikethis]']);
		$three = $I->havePostInDatabase(['post_content' => 'lorem[idlikethis]foo[/idlikethis]']);
		$I->haveUserInDatabase('editor', 'editor', ['user_pass' => 'password']);

		$I->loginAs('editor', 'password');
		$I->amOnAdminPage('/');
		$wp_rest_nonce = $I->grabValueFrom('input[name="rest_nonce"]');
		$I->haveHttpHeader('X-WP-Nonce', $wp_rest_nonce);
		$I->sendAjaxPostRequest('/wp-json/idlikethis/v1/admin/clean-all');

		$I->seePostInDatabase(['ID' => $one, 'post_content' => 'lorem']);
		$I->seePostInDatabase(['ID' => $two, 'post_content' => 'lorem[idlikethis]']);
		$I->seePostInDatabase(['ID' => $three, 'post_content' => 'lorem[idlikethis]foo[/idlikethis]']);
	}
}