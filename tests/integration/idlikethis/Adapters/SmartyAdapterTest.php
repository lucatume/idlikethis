<?php
namespace idlikethis\Adapters;

use idlikethis_Adapters_SmartyAdapter as SmartyAdapter;
use Prophecy\Argument;

class SmartyAdapterTest extends \Codeception\TestCase\WPTestCase
{
    /**
     * @var \Smarty
     */
    protected $smarty;

    public function setUp()
    {
        // before
        parent::setUp();

        // your set up methods here
        $this->smarty = $this->prophesize('Smarty');
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

        $this->assertInstanceOf('idlikethis_Adapters_SmartyAdapter', $sut);
    }

    /**
     * @test
     * it should assign no template vars if template data is empty
     */
    public function it_should_assign_no_template_vars_if_template_data_is_empty()
    {
        $sut = $this->make_instance();

        $this->smarty->assign(Argument::any())->shouldNotBeCalled();
        $this->smarty->fetch(Argument::any())->willReturn('foo');

        $sut->render('some-template', []);
    }

    /**
     * @test
     * it should assign template vars
     */
    public function it_should_assign_template_vars()
    {
        $sut = $this->make_instance();

        $this->smarty->assign('key1', 'value1')->shouldBeCalled();
        $this->smarty->assign('key2', 'value2')->shouldBeCalled();
        $this->smarty->fetch(Argument::any())->willReturn('foo');

        $sut->render('some-template', ['key1' => 'value1', 'key2' => 'value2']);
    }

    /**
     * @test
     * it should call display method on Smarty
     */
    public function it_should_call_display_method_on_smarty()
    {
        $sut = $this->make_instance();

        $this->smarty->assign('key1', 'value1')->shouldBeCalled();
        $this->smarty->assign('key2', 'value2')->shouldBeCalled();
        $this->smarty->fetch('some-template.tpl')->willReturn('foo');

        $sut->render('some-template', ['key1' => 'value1', 'key2' => 'value2']);
    }


    private function make_instance()
    {
        $sut = new SmartyAdapter($this->smarty->reveal());
        return $sut;

    }
}