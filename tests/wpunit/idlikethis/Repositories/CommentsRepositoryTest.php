<?php
namespace idlikethis\Repositories;

use idlikethis_Repositories_CommentsRepository as CommentsRepository;

class CommentsRepositoryTest extends \Codeception\TestCase\WPTestCase
{

    public function setUp()
    {
        // before
        parent::setUp();

        // your set up methods here
    }

    public function tearDown()
    {
        // your tear down methods here

        // then
        parent::tearDown();
    }

    /**
     * @test
     * it should be instantiatable
     */
    public function it_should_be_instantiatable()
    {
        $this->assertInstanceOf('idlikethis_Repositories_CommentsRepository', $this->make_instance());
    }

    /**
     * @test
     * it should return false if trying to add a comment to a non existing post
     */
    public function it_should_return_false_if_trying_to_add_a_comment_to_a_non_existing_post()
    {
        $sut = $this->make_instance();

        $out = $sut->add_for_post(215, 'some content');

        $this->assertFalse($out);
    }

    /**
     * @test
     * it should return false if trying to add a commment without content
     */
    public function it_should_return_false_if_trying_to_add_a_commment_without_content()
    {
        $sut = $this->make_instance();

        $post_id = $this->factory()->post->create(['post_type' => 'post']);
        $out = $sut->add_for_post($post_id, '');

        $this->assertFalse($out);
    }

    /**
     * @test
     * it should return the comment number id when adding a comment to a post
     */
    public function it_should_return_the_comment_number_id_when_adding_a_comment_to_a_post()
    {
        $sut = $this->make_instance();

        $post_id = $this->factory()->post->create(['post_type' => 'post']);
        $out = $sut->add_for_post($post_id, 'some-comment');

        $comments = get_comments(['post_id' => $post_id]);
        $comment = reset($comments);

        $this->assertEquals($comment->comment_ID, $out);
    }

    /**
     * @test
     * it should set the comment user to the current user
     */
    public function it_should_set_the_comment_user_to_the_current_user()
    {
        $sut = $this->make_instance();
        $user_id = get_current_user_id();

        $post_id = $this->factory()->post->create(['post_type' => 'post']);
        $out = $sut->add_for_post($post_id, 'some-comment');

        $comments = get_comments(['post_id' => $post_id]);
        $comment = reset($comments);


        $this->assertEquals($user_id, $comment->user_id, $out);
    }

    private function make_instance()
    {
        return new CommentsRepository();
    }

}