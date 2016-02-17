<?php
namespace idlikethis\MetaBoxes;

use idlikethis_MetaBoxes_PostControlMetaBox as PostControlMetaBox;

class PostControlMetaBoxTest extends \Codeception\TestCase\WPTestCase
{
    /**
     * @var \idlikethis_Repositories_CommentsRepositoryInterface
     */
    protected $comments_repository;

    /**
     * @var \idlikethis_Texts_PostControlMetaBoxTextsProviderInterface
     */
    protected $texts_provider;

    /**
     * @var \idlikethis_Templates_RenderEngineInterface
     */
    protected $rendering_engine;

    /**
     * @var \idlikethis_Contexts_MetaBoxContextInterface
     */
    protected $context;

    public function setUp()
    {
        // before
        parent::setUp();

        // your set up methods here
        $this->comments_repository = $this->prophesize('idlikethis_Repositories_CommentsRepositoryInterface');
        $this->rendering_engine = $this->prophesize('idlikethis_Templates_RenderEngineInterface');
        $this->texts_provider = $this->prophesize('idlikethis_Texts_PostControlMetaBoxTextsProviderInterface');
        $this->context = $this->prophesize('idlikethis_Contexts_MetaBoxContextInterface');
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
        $sut = $this->make_instance();

        $this->assertInstanceOf('idlikethis_MetaBoxes_PostControlMetaBox', $sut);
    }

    /**
     * @test
     * it should show a nothing to control text if there are not idlikethis comments associated to the post
     */
    public function it_should_show_a_nothing_to_control_text_if_there_are_not_idlikethis_comments_associated_to_the_post()
    {
        $post = $this->factory()->post->create_and_get();

        $this->comments_repository->get_comments_for_post($post)->willReturn([]);

        $this->texts_provider->get_empty_comments_text()->shouldBeCalled();

        $sut = $this->make_instance();

        $sut->render($post, []);
    }

    /**
     * @test
     * it should show the reset all comments control if there are idlikethis comments associated to the post
     */
    public function it_should_show_the_reset_all_idlikethis_comments_control_if_there_are_idlikethis_comments_associated_to_the_post()
    {
        $post = $this->factory()->post->create_and_get();

        $comments_ids = $this->factory()->comment->create_many(3, ['comment_post_ID' => $post->ID, 'comment_type' => 'idlikethis']);
        $this->comments_repository->get_comments_for_post($post)->willReturn(['some idea' => $comments_ids]);

        $this->context->get_post_id()->willReturn($post->ID);
        $this->texts_provider->get_comments_title_text()->shouldBeCalled();
        $this->texts_provider->get_reset_all_text()->shouldBeCalled();
        $this->texts_provider->get_consolidate_all_text()->willReturn('foo');

        $sut = $this->make_instance();

        $sut->render($post, []);
    }

    /**
     * @test
     * it should show the consolidate all comments control if there are idlikethis comments associated to the post
     */
    public function it_should_show_the_consolidate_all_comments_control_if_there_are_idlikethis_comments_associated_to_the_post()
    {
        $post = $this->factory()->post->create_and_get();

        $comments_ids = $this->factory()->comment->create_many(3, ['comment_post_ID' => $post->ID, 'comment_type' => 'idlikethis']);
        $this->comments_repository->get_comments_for_post($post)->willReturn(['some idea' => $comments_ids]);

        $this->context->get_post_id()->willReturn($post->ID);
        $this->texts_provider->get_comments_title_text()->shouldBeCalled();
        $this->texts_provider->get_reset_all_text()->willReturn('foo');
        $this->texts_provider->get_consolidate_all_text()->shouldBeCalled();

        $sut = $this->make_instance();

        $sut->render($post, []);
    }

    private function make_instance()
    {
        return new PostControlMetaBox($this->comments_repository->reveal(), $this->rendering_engine->reveal(), $this->texts_provider->reveal(), $this->context->reveal());
    }
}