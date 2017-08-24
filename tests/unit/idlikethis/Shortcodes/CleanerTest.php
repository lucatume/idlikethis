<?php

namespace idlikethis\Shortcodes;

use idlikethis_Shortcodes_Cleaner as Cleaner;
use PHPUnit\Framework\Assert;
use Prophecy\Argument;

class CleanerTest extends \Codeception\Test\Unit {

	/**
	 * @var \UnitTester
	 */
	protected $tester;

	/**
	 * @var \idlikethis_Repositories_PostRepositoryInterface
	 */
	protected $repository;

	protected function _before() {
		$this->repository = $this->prophesize(\idlikethis_Repositories_PostRepositoryInterface::class);
	}

	/**
	 * @return Cleaner
	 */
	private function make_instance() {
		return new Cleaner($this->repository->reveal());
	}

	/**
	 * @test
	 * it should be instantiatable
	 */
	public function it_should_be_instantiatable() {
		$sut = $this->make_instance();

		$this->assertInstanceOf(Cleaner::class, $sut);
	}

	/**
	 * It should remove shortcodes from all posts
	 *
	 * @test
	 */
	public function should_remove_shortcodes_from_all_posts() {
		$contents_map                 = [
			1 => 'Lorem dolor',
			2 => 'Lorem dolor[idlikethis]',
			3 => 'Lorem dolor[idlikethis] ipsum',
			4 => 'Lorem dolor[idlikethis]woo[/idlikethis]',
			5 => 'Lorem dolor[idlikethis]woo[/idlikethis] ipsum',
			6 => 'Lorem dolor[idlikethis] Lorem dolor[idlikethis]',
			7 => 'Lorem dolor[idlikethis] ipsum Lorem dolor[idlikethis] ipsum',
			8 => 'Lorem dolor[idlikethis]woo[/idlikethis] Lorem dolor[idlikethis]woo[/idlikethis]',
			9 => 'Lorem dolor[idlikethis]woo[/idlikethis] ipsum Lorem dolor[idlikethis]woo[/idlikethis] ipsum',
		];
		$expected_updated_content_map = [
			1 => 'Lorem dolor',
			2 => 'Lorem dolor',
			3 => 'Lorem dolor ipsum',
			4 => 'Lorem dolor',
			5 => 'Lorem dolor ipsum',
			6 => 'Lorem dolor Lorem dolor',
			7 => 'Lorem dolor ipsum Lorem dolor ipsum',
			8 => 'Lorem dolor Lorem dolor',
			9 => 'Lorem dolor ipsum Lorem dolor ipsum',
		];
		$post_ids                     = array_keys($contents_map);
		$this->repository->get_posts_with_shortcodes()->willReturn($post_ids);
		$this->repository->get_post_content(Argument::type('int'))->will(function ($args) use ($contents_map) {
			$post_id = reset($args);
			return $contents_map[$post_id];

		});

		$this->repository->set_post_content(Argument::type('int'), Argument::type('string'))
						 ->will(function ($args) use ($expected_updated_content_map) {
							 list($post_id, $post_content) = $args;
							 Assert::assertEquals($expected_updated_content_map[$post_id], $post_content);
						 });

		$sut = $this->make_instance();

		$sut->clean_all();
	}

	/**
	 * It should not update any post content if the post content does not contain the shortcode
	 *
	 * @test
	 */
	public function should_not_update_any_post_content_if_the_post_content_does_not_contain_the_shortcode() {
		$contents_map = [
			1 => 'Lorem dolor',
			2 => 'Lorem dolor',
			3 => 'Lorem dolor ipsum',
		];
		$post_ids                     = array_keys($contents_map);
		$this->repository->get_posts_with_shortcodes()->willReturn($post_ids);
		$this->repository->get_post_content(Argument::type('int'))->will(function ($args) use ($contents_map) {
			$post_id = reset($args);
			return $contents_map[$post_id];

		});

		$this->repository->set_post_content(Argument::type('int'), Argument::type('string'))->shouldNotBeCalled();

		$sut = $this->make_instance();

		$sut->clean_all();
	}

	/**
	 * It should not update any post content if there are no posts
	 *
	 * @test
	 */
	public function should_not_update_any_post_content_if_there_are_no_posts() {
		$this->repository->get_posts_with_shortcodes()->willReturn([]);
		$this->repository->get_post_content(Argument::type('int'))->shouldNotBeCalled();
		$this->repository->set_post_content(Argument::type('int'), Argument::type('string'))->shouldNotBeCalled();

		$sut = $this->make_instance();

		$sut->clean_all();
	}
}