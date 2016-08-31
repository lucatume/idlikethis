<?php
namespace idlikethis\Endpoints;

use idlikethis_Endpoints_ButtonClickHandler as ButtonClickHandler;
use Prophecy\Argument;

class ButtonClickHandlerTest extends \Codeception\TestCase\WPRestApiTestCase
{

    /**
     * @var \idlikethis_Endpoints_AuthHandlerInterface
     */
    protected $auth_handler;

    /**
     * @var \idlikethis_Repositories_VotesRepositoryInterface
     */
    protected $comment_repository;


    public function setUp()
    {
        // before
        parent::setUp();

        // your set up methods here
        $this->auth_handler = $this->prophesize('idlikethis_Endpoints_AuthHandlerInterface');
        $this->comment_repository = $this->prophesize('idlikethis_Repositories_VotesRepositoryInterface');
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
    }

    /**
     * @test
     * it should return 403 response if verification fails
     */
    public function it_should_return_403_response_if_verification_fails()
    {
        $this->auth_handler->verify_auth(Argument::any(), Argument::any())->willReturn(false);

        $sut = $this->make_instance();

        $out = $sut->handle(new \WP_REST_Request('create', '/some-path', ['post_id' => 123, 'content' => 'foo']));

        $this->assertErrorResponse(403, $out);
    }

    /**
     * @test
     * it should return 400 response if request is missing post id
     */
    public function it_should_return_400_response_if_request_is_missing_post_id()
    {
        $this->auth_handler->verify_auth(Argument::any(), Argument::any())->willReturn(true);
        $_POST['content'] = 'foo';

        $sut = $this->make_instance();

        $out = $sut->handle(new \WP_REST_Request('create', '/some-path', ['content' => 'foo']));

        $this->assertErrorResponse(400, $out);
    }

    /**
     * @test
     * it should return 400 status if request is missing content
     */
    public function it_should_return_400_status_if_request_is_missing_content()
    {
        $this->auth_handler->verify_auth(Argument::any(), Argument::any())->willReturn(true);

        $sut = $this->make_instance();

        $out = $sut->handle(new \WP_REST_Request('create', '/some-path', ['post_id' => 123]));

        $this->assertErrorResponse(400, $out);
    }

    /**
     * @test
     * it should return 400 response if comment insertion fails
     */
    public function it_should_return_400_response_if_comment_insertion_fails()
    {
        $this->auth_handler->verify_auth(Argument::any(), Argument::any())->willReturn(true);
        $this->comment_repository->add_vote_for_post(Argument::any(), Argument::any())->willReturn(false);

        $sut = $this->make_instance();

        $out = $sut->handle(new \WP_REST_Request('create', '/some-path', ['post_id' => 123, 'content' => 'foo']));

        $this->assertErrorResponse(400, $out);
    }

    /**
     * @test
     * it should return 200 response if comment insertion succeeds
     */
    public function it_should_return_200_response_if_comment_insertion_succeeds()
    {
        $this->auth_handler->verify_auth(Argument::any(), Argument::any())->willReturn(true);
        $this->comment_repository->add_vote_for_post(Argument::any(), Argument::any())->willReturn(112);

        $sut = $this->make_instance();

        /** @var \WP_REST_Response $out */
        $request = new \WP_REST_Request();
        $request->set_param('post_id', 123);
        $request->set_param('content', 'some content');
        $out = $sut->handle($request);

        $this->assertEquals(200, $out->status);
        $this->assertEquals(112, $out->data);
    }

    protected function make_instance()
    {
        return new ButtonClickHandler($this->auth_handler->reveal(), $this->comment_repository->reveal());
    }

}