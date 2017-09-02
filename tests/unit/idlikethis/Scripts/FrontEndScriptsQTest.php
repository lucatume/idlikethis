<?php

namespace idlikethis\Scripts;

use idlikethis_Scripts_FrontEndScriptsQ as Q;
use PHPUnit\Framework\Assert;
use function tad\FunctionMockerLe\define;
use function tad\FunctionMockerLe\defineAll;
use function tad\FunctionMockerLe\undefineAll;

class FrontEndScriptsQTest extends \Codeception\Test\Unit {

	/**
	 * @var \idlikethis_Plugin
	 */
	protected $plugin;

	/**
	 * @var \idlikethis_Scripts_FrontEndDataProviderInterface
	 */
	protected $data_provider;

	public function _before() {
		undefineAll();
		// your set up methods here
		$this->plugin        = $this->prophesize('idlikethis_Plugin');
		$this->data_provider = $this->prophesize('idlikethis_Scripts_FrontEndDataProviderInterface');
		defineAll(['wp_localize_script', 'wp_nonce_field', 'wp_enqueue_script'], function () {
			return true;
		});
	}

	/**
	 * @test
	 * it should be instantiatable
	 */
	public function it_should_be_instantiatable() {
		$sut = $this->make_instance();
		$this->assertInstanceOf('idlikethis_Scripts_FrontEndScriptsQ', $sut);
	}

	private function make_instance() {
		return new Q($this->plugin->reveal(), $this->data_provider->reveal());
	}

	/**
	 * @test
	 * it should q the standard version of the script
	 */
	public function it_should_q_the_standard_version_of_the_script() {
		$sut = $this->make_instance();

		$this->plugin->dir_url('assets/js/dist/idlikethis.js')->willReturn('foo.js');
		$calls = 0;
		define('wp_enqueue_script', function () use (&$calls) {
			$calls++;
			Assert::assertEquals(['idlikethis', 'foo.js', ['backbone'], null, true], func_get_args());
		});

		$sut->enqueue();

		$this->assertEquals(1, $calls);
	}

	/**
	 * @test
	 * it should localize the script data
	 */
	public function it_should_localize_the_script_data() {
		$sut = $this->make_instance();

		$this->plugin->dir_url('assets/js/dist/idlikethis.js')->willReturn('foo.js');
		$data = ['some' => 'data'];
		$this->data_provider->get_data()->willReturn($data);
		define('wp_localize_script', function () use (&$calls, $data) {
			$calls++;
			Assert::assertEquals(['idlikethis', 'idlikethisData', $data], func_get_args());
		});

		$sut->enqueue();

		$this->assertEquals(1, $calls);
	}
}