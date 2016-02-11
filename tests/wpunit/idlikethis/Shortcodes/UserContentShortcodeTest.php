<?php
namespace idlikethis\Shortcodes;

use idlikethis_Shortcodes_UserContentShortcode as UserContentShortcode;
use Prophecy\Argument;

class UserContentShortcodeTest extends \Codeception\TestCase\WPTestCase
{
    /**
     *  idlikethis_Templates_RenderEngineInterface
     */
    protected $render_engine;

    /**
     * @var \idlikethis_Texts_ProviderInterface
     */
    protected $text_provider;

    /**
     * @var \idlikethis_Contexts_ShortcodeContextInterface
     */
    protected $context;

    public function setUp()
    {
        // before
        parent::setUp();

        // your set up methods here
        $this->render_engine = $this->prophesize('idlikethis_Templates_RenderEngineInterface');
        $this->text_provider = $this->prophesize('idlikethis_Texts_ProviderInterface');
        $this->context = $this->prophesize('idlikethis_Contexts_ShortcodeContextInterface');
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

        $this->assertInstanceOf('idlikethis_Shortcodes_UserContentShortcode', $sut);
    }

    /**
     * @test
     * it should return the context default text if the content is not provided
     */
    public function it_should_return_the_context_default_text_if_the_content_is_not_provided()
    {
        $sut = $this->make_instance();
        $this->context->get_post_id()->willReturn(23);
        $this->context->get_comment_text()->willReturn('default text');

        $this->render_engine->render(Argument::any(), Argument::withEntry('comment_text', 'default text'))->shouldBeCalled();

        $out = $sut->render([]);
    }

    /**
     * @test
     * it should return the default context text if the content is empty string
     */
    public function it_should_return_the_default_context_text_if_the_content_is_not_a_string()
    {
        $sut = $this->make_instance();
        $content = '';
        $this->context->get_post_id()->willReturn(23);
        $this->context->get_comment_text()->willReturn('default text');

        $this->render_engine->render(Argument::any(), Argument::withEntry('comment_text', 'default text'))->shouldBeCalled();

        $out = $sut->render([], $content);
    }

    /**
     * @test
     * it should return the escaped content if provided
     */
    public function it_should_return_the_escaped_content_if_provided()
    {
        $sut = $this->make_instance();
        $this->context->get_post_id()->willReturn(23);
        $this->context->get_comment_text()->willReturn('default text');
        $content = 'some&content$$<>';

        $this->render_engine->render(Argument::any(), Argument::withEntry('comment_text', esc_attr($content)))->shouldBeCalled();

        $out = $sut->render([], $content);
    }

    protected function make_instance()
    {
        return new UserContentShortcode($this->render_engine->reveal(), $this->text_provider->reveal(), $this->context->reveal());
    }

}