<?php

namespace idlikethis\Scripts;

use idlikethis_Scripts_BackEndScriptsQ as Q;
use PHPUnit\Framework\Assert;
use function tad\FunctionMockerLe\define;
use function tad\FunctionMockerLe\defineAll;

class BackEndScriptsQTest extends \Codeception\Test\Unit {

	/**
	 * @var \idlikethis_plugin
	 */
	protected $plugin;

	/**
	 * @var \idlikethis_scripts_backenddataproviderinterface
	 */
	protected $data_provider;

	public function _before() {
		$this->plugin        = $this->prophesize('idlikethis_Plugin');
		$this->data_provider = $this->prophesize('idlikethis_Scripts_BackEndDataProviderInterface');
		defineAll(['wp_localize_script', 'wp_nonce_field'], function () {
			return true;
		});
	}

	/**
	 * @test
	 * it should be instantiatable
	 */
	public function it_should_be_instantiatable() {
		$sut = $this->make_instance();
		$this->assertinstanceof('idlikethis_Scripts_BackEndScriptsQ', $sut);
	}

	private function make_instance() {
		return new q($this->plugin->reveal(), $this->data_provider->reveal());
	}

	/**
	 * @test
	 * it should q the standard version of the script
	 */
	public function it_should_q_the_standard_version_of_the_script() {
		$sut = $this->make_instance();

		$this->plugin->dir_url('assets/js/dist/idlikethis-admin.js')->willreturn('foo.js');

		$calls = 0;
		define('wp_enqueue_script', function () use (&$calls) {
			$calls++;
			assert::assertequals(['idlikethis-admin', 'foo.js', ['backbone'], null, true], func_get_args());
		});

		$sut->enqueue();
		$this->assertequals(1, $calls);
	}

	/**
	 * @test
	 * it should localize the script data
	 */
	public function it_should_localize_the_script_data() {
		$sut = $this->make_instance();

		$this->plugin->dir_url('assets/js/dist/idlikethis-admin.js')->willreturn('foo.js');
		$data = ['some' => 'data'];
		$this->data_provider->get_data()->willreturn($data);
		$calls = 0;
		define('wp_localize_script', function () use (&$calls, $data) {
			$calls++;
			assert::assertequals(['idlikethis-admin', 'idlikethisData', $data], func_get_args());
		});

		$sut->enqueue();

		$this->assertequals(1, $calls);
	}
}