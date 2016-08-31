<?php
namespace idlikethis\Scripts;

use tad\FunctionMocker\FunctionMocker as Test;
use idlikethis_Scripts_BackEndScriptsQ as Q;

class BackEndScriptsQTest extends \Codeception\TestCase\WPTestCase
{

    /**
     * @var \idlikethis_Plugin
     */
    protected $plugin;

    /**
     * @var \idlikethis_Scripts_BackEndDataProviderInterface
     */
    protected $data_provider;

    public function setUp()
    {
        // before
        parent::setUp();

        // your set up methods here
        Test::setUp();
        $this->plugin = $this->prophesize('idlikethis_Plugin');
        $this->data_provider = $this->prophesize('idlikethis_Scripts_BackEndDataProviderInterface');
    }

    public function tearDown()
    {
        // your tear down methods here
        Test::tearDown();

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
        $this->assertInstanceOf('idlikethis_Scripts_BackEndScriptsQ', $sut);
    }

    /**
     * @test
     * it should q the standard version of the script
     */
    public function it_should_q_the_standard_version_of_the_script()
    {
        $sut = $this->make_instance();

        $this->plugin->dir_url('assets/js/dist/idlikethis-admin.js')->willReturn('foo.js');
        $wp_enqueue_script = Test::replace('wp_enqueue_script');

        $sut->enqueue();

        $wp_enqueue_script->wasCalledWithOnce(['idlikethis-admin', 'foo.js', ['backbone'], null, true]);
    }

    /**
     * @test
     * it should localize the script data
     */
    public function it_should_localize_the_script_data()
    {
        $sut = $this->make_instance();

        $this->plugin->dir_url('assets/js/dist/idlikethis-admin.js')->willReturn('foo.js');
        $data = ['some' => 'data'];
        $this->data_provider->get_data()->willReturn($data);
        $wp_localize_script = Test::replace('wp_localize_script');

        $sut->enqueue();

        $wp_localize_script->wasCalledWithOnce(['idlikethis-admin', 'idlikethisData', $data]);

    }


    private function make_instance()
    {
        return new Q($this->plugin->reveal(), $this->data_provider->reveal());
    }

}