<?php

namespace ZfSimpleAuthTest\Controller;

use Zend\Test\PHPUnit\Controller\AbstractHttpControllerTestCase;
use ZfSimpleAuthTests\Bootstrap;

class AuthControllerTest extends AbstractHttpControllerTestCase
{
    public function setUp()
    {
        $this->setApplicationConfig(
            Bootstrap::getConfig()
        );
        parent::setUp();
    }

    /**
     * @covers \ZfSimpleAuth\Controller\AuthController::loginAction
     */
    public function testLoginActionCanBeAccessed()
    {
        $this->dispatch('/login');
        $this->assertResponseStatusCode(200);

        $this->assertModuleName('ZfSimpleAuth');
        $this->assertControllerName('ZfSimpleAuth\Controller\Auth');
        $this->assertControllerClass('AuthController');
        $this->assertMatchedRouteName('login');
    }

    /**
     * @covers \ZfSimpleAuth\Controller\AuthController::loginAction
     */
    public function testLoginWithBadName()
    {
        $postData = array(
            'username'  => 'bad username',
            'pwd' => 'bad password',
        );
        $this->dispatch('/login', 'POST', $postData);
        $this->assertResponseStatusCode(303);
        $this->assertRedirectTo('login');

        $this->dispatch('/login', 'GET');
        // redirect after bad login
        $this->assertResponseStatusCode(302);
    }

    /**
     * @covers \ZfSimpleAuth\Controller\AuthController::loginAction
     */
    public function testLoginWithGoodCredentials()
    {
        $postData = array(
            'username'  => 'demo-admin',
            'pwd' => 'foobar',
        );
        $this->dispatch('/login', 'POST', $postData);
        $this->assertResponseStatusCode(303);
        $this->assertRedirect();
    }

    /**
     * @covers \ZfSimpleAuth\Controller\AuthController::logoutAction
     */
    public function testLogout()
    {
        $this->dispatch('/logout');
        $this->assertResponseStatusCode(302);
        $this->assertRedirect();
    }
}
