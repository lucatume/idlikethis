<?php
namespace idlikethis\Shortcodes;

use idlikethis_Shortcodes_Simple as Simple;

class SimpleTest extends \Codeception\TestCase\WPTestCase
{
    /**
     *  idlikethis_Templates_RenderEngineInterface
     */
    protected $render_engine;

    /**
     * @var \idlikethis_Texts_ShortcodeTextProviderInterface
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
        $this->text_provider = $this->prophesize('idlikethis_Texts_ShortcodeTextProviderInterface');
        $this->context = $this->prophesize('idlikethis_Contexts_ShortcodeContextInterface');
    }

    public function tearDown()
    {
        // your tear down methods here

        // then
        parent::tearDown();
    }

    protected function make_instance()
    {
        return new Simple($this->render_engine->reveal(), $this->text_provider->reveal(), $this->context->reveal());
    }

    /**
     * @test
     * it should be instantiatable
     */
    public function it_should_be_instantiatable()
    {
        $sut = $this->make_instance();
        $this->assertInstanceOf('idlikethis_Shortcodes_Simple', $sut);
    }

    /**
     * @test
     * it should call the render engine with data when rendering
     */
    public function it_should_call_the_render_engine_with_data_when_rendering()
    {
        $sut = $this->make_instance();

        $this->context->get_comment_text()->willReturn('some text');
        $this->context->get_post_id()->willReturn(23);

        $data = array('some' => 'value', 'some_other' => 'value', 'comment_text' => 'some text', 'post_id' => 23);
        $sut->set_template_slug('some/slug');
        $sut->set_template_data($data);

        $this->render_engine->render('some/slug', $data)->shouldBeCalled();

        $sut->render();
    }

    /**
     * @test
     * it should throw if trying to set template slug to non string
     */
    public function it_should_throw_if_trying_to_set_template_slug_to_non_string()
    {
        $sut = $this->make_instance();

        $this->setExpectedException('InvalidArgumentException');

        $sut->set_template_slug(23);
    }

    /**
     * @test
     * it should throw if trying to set the template slug to empty string
     */
    public function it_should_throw_if_trying_to_set_the_template_slug_to_empty_string()
    {
        $sut = $this->make_instance();

        $this->setExpectedException('InvalidArgumentException');

        $sut->set_template_slug('');
    }
}
