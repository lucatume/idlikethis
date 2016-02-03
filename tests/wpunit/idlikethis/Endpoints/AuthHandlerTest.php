<?php
namespace idlikethis\Endpoints;

use idlikethis_Endpoints_AuthHandler as AuthHandler;

class AuthHandlerTest extends \Codeception\TestCase\WPTestCase
{

    public function setUp()
    {
        // before
        parent::setUp();

        // your set up methods here
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
        $this->assertInstanceOf('idlikethis_Endpoints_AuthHandler', $this->make_instance());
    }

    /**
     * @test
     * it should return false if data does not contain auth argument
     */
    public function it_should_return_false_if_data_does_not_contain_auth_argument()
    {
        $data = ['foo' => 'var'];

        $sut = $this->make_instance();

        $this->assertFalse($sut->verify_auth($data, 'some-action'));
    }

    /**
     * @test
     * it should return false if nonce verification fails for action
     */
    public function it_should_return_false_if_nonce_verification_fails_for_action()
    {
        $data = ['auth' => 'invalid-nonce'];

        $sut = $this->make_instance();

        $this->assertFalse($sut->verify_auth($data, 'some-action'));
    }

    /**
     * @test
     * it should throw if passing non string action
     */
    public function it_should_throw_if_passing_non_string_action()
    {
        $data = ['auth' => 'invalid-nonce'];

        $sut = $this->make_instance();

        $this->setExpectedException('InvalidArgumentException');

        $this->assertFalse($sut->verify_auth($data, 23));
    }

    /**
     * @test
     * it should return true if nonce verification passes
     */
    public function it_should_return_true_if_nonce_verification_passes()
    {
        $nonce = wp_create_nonce('some-action');
        $data = ['auth' => $nonce];

        $sut = $this->make_instance();

        $this->assertTrue($sut->verify_auth($data, 'some-action'));
    }

    /**
     * @return AuthHandler
     */
    public function make_instance()
    {
        return new AuthHandler();
    }

}