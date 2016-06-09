<?php


class ButtonClickPostRequestCest
{
    public function _before(FunctionalTester $I)
    {
    }

    public function _after(FunctionalTester $I)
    {
    }

    /**
     * @test
     * it should not insert any comment if post ID is missing from POST request
     */
    public function it_should_not_insert_any_comment_if_post_id_is_missing_from_post_request(FunctionalTester $I)
    {
        $I->sendAjaxPostRequest('/wp-json/idlikethis/v1/button-click', [
            'nonce' => $I->createNonce('wp_rest', 1),
            'content' => 'Some content',
        ]);

        $I->dontSeeCommentInDatabase(['comment_content' => 'Some content']);
    }

    /**
     * @test
     * it should not insert any comment if post ID is not a valid post ID
     */
    public function it_should_not_insert_any_comment_if_post_id_is_not_a_valid_post_id(FunctionalTester $I)
    {
        $I->sendAjaxPostRequest('/wp-json/idlikethis/v1/button-click', [
            'nonce' => $I->createNonce('wp_rest', 1),
            'content' => 'Some content',
            'post_id' => 3344
        ]);

        $I->dontSeeCommentInDatabase(['comment_content' => 'Some content']);
    }

    /**
     * @test
     * it should not insert any comment if content is missing from POST request
     */
    public function it_should_not_insert_any_comment_if_content_is_missing_from_post_request(FunctionalTester $I)
    {
        $post_id = $I->havePostInDatabase(['post_title' => 'Some post']);

        $I->sendAjaxPostRequest('/wp-json/idlikethis/v1/button-click', [
            'nonce' => $I->createNonce('wp_rest', 1),
            'post_id' => $post_id
        ]);

        $I->dontSeeCommentInDatabase(['comment_post_ID' => $post_id]);
    }

    /**
     * @test
     * it should insert a comment when hitting the endpoint with valid params
     */
    public function it_should_insert_a_comment_when_hitting_the_endpoint_with_valid_params(FunctionalTester $I)
    {
        $post_id = $I->havePostInDatabase(['post_title' => 'Some post']);

        $I->sendAjaxPostRequest('/wp-json/idlikethis/v1/button-click', [
            'nonce' => $I->createNonce('wp_rest', 1),
            'post_id' => $post_id,
            'content' => 'Some content'
        ]);
        
        $I->seeCommentInDatabase(['comment_post_ID' => $post_id]);
    }
}
