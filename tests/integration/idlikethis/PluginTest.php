<?php
namespace idlikethis;

use idlikethis_Plugin as Plugin;

class PluginTest extends \Codeception\TestCase\WPTestCase
{

    /**
     * @var string
     */
    protected $root_dir;

    public function setUp()
    {
        // before
        parent::setUp();

        // your set up methods here
        $this->root_dir = dirname(dirname(dirname(__FILE__)));
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
        $this->assertInstanceOf('idlikethis_Plugin', $sut);
    }

    private function make_instance() {
        return new Plugin();
    }

    /**
     * @test
     * it should throw if trying to get dir_path of non string
     */
    public function it_should_throw_if_trying_to_get_dir_path_of_non_string()
    {
        $sut = $this->make_instance();

        $this->setExpectedException('InvalidArgumentException');

        $sut->dir_path(23);
    }

    /**
     * @test
     * it should return dir_path to relative frag
     */
    public function it_should_return_dir_path_to_relative_frag()
    {
        $sut = $this->make_instance();

        $out = $sut->dir_path('some/frag.extension');

        $this->assertEquals(plugin_dir_path($this->root_dir) . 'some/frag.extension', $out);
    }

    /**
     * @test
     * it should throw if trying to get dir_url of non string
     */
    public function it_should_throw_if_trying_to_get_dir_url_of_non_string()
    {
        $sut = $this->make_instance();

        $this->setExpectedException('InvalidArgumentException');

        $sut->dir_url(23);
    }

    /**
     * @test
     * it should return dir_url to relative frag
     */
    public function it_should_return_dir_url_to_relative_frag()
    {
        $sut = $this->make_instance();

        $out = $sut->dir_url('some/frag.extension');

        $this->assertEquals(plugin_dir_url($this->root_dir) . 'some/frag.extension', $out);
    }
}