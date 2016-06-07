<?php
namespace idlikethis\Comments;

use idlikethis_Comments_TableFilter as TableFilter;

class TableFilterTest extends \Codeception\TestCase\WPTestCase
{
    /**
     * @var idlikethis_Comments_TableContextInterface
     */
    protected $context;
    protected $types;

    public function setUp()
    {
        // before
        parent::setUp();

        // your set up methods here
        $this->types = 'some-commment-type';
        $this->context = $this->prophesize('idlikethis_Comments_TableContextInterface');
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

        $this->assertInstanceOf('idlikethis_Comments_TableFilter', $sut);
    }

    private function make_instance() {
        return new TableFilter( $this->types, $this->context->reveal() );
    }

    /**
     * @test
     * it should not add the type__not_in query var if not the right context
     */
    public function it_should_not_add_the_types_not_in_query_var_if_not_the_right_context()
    {
        $this->context->is_comments_edit_screen()->willReturn(false);

        $sut = $this->make_instance();

        $query = $this->getMockBuilder('WP_Comment_Query')->disableOriginalConstructor()->getMock();
        $query->query_vars = [];
        $query->query_vars['type__not_in'] = [];

        $sut->on_pre_get_comments($query);

        $this->assertEmpty($query->query_vars['type__not_in']);
    }

    /**
     * @test
     * it should not add the type__not_in query var if types empty
     */
    public function it_should_not_add_the_types_not_in_query_var_if_types_empty()
    {
        $this->types = [];
        $this->context->is_comments_edit_screen()->willReturn(true);

        $sut = $this->make_instance();

        $query = $this->getMockBuilder('WP_Comment_Query')->disableOriginalConstructor()->getMock();
        $query->query_vars = [];
        $query->query_vars['type__not_in'] = [];

        $sut->on_pre_get_comments($query);

        $this->assertEmpty($query->query_vars['type__not_in']);
    }

    /**
     * @test
     * it should add the type__not_in query var
     */
    public function it_should_add_the_type_not_in_query_var()
    {
        $this->context->is_comments_edit_screen()->willReturn(true);

        $sut = $this->make_instance();

        $query = $this->getMockBuilder('WP_Comment_Query')->disableOriginalConstructor()->getMock();
        $query->query_vars = [];
        $query->query_vars['type__not_in'] = [];

        $sut->on_pre_get_comments($query);

        $this->assertEquals((array)$this->types, $query->query_vars['type__not_in']);
    }

    /**
     * @test
     * it should preserve existing type exclusions
     */
    public function it_should_preserve_existing_type_exclusions()
    {
        $this->context->is_comments_edit_screen()->willReturn(true);

        $sut = $this->make_instance();

        $query = $this->getMockBuilder('WP_Comment_Query')->disableOriginalConstructor()->getMock();
        $query->query_vars = [];
        $query->query_vars['type__not_in'] = ['some-other-type'];

        $sut->on_pre_get_comments($query);

        $this->assertEquals(array_merge(['some-other-type'], (array)$this->types), $query->query_vars['type__not_in']);
    }


}