<?php
/*
 * THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS
 * "AS IS" AND ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT
 * LIMITED TO, THE IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS FOR
 * A PARTICULAR PURPOSE ARE DISCLAIMED. IN NO EVENT SHALL THE COPYRIGHT
 * OWNER OR CONTRIBUTORS BE LIABLE FOR ANY DIRECT, INDIRECT, INCIDENTAL,
 * SPECIAL, EXEMPLARY, OR CONSEQUENTIAL DAMAGES (INCLUDING, BUT NOT
 * LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES; LOSS OF USE,
 * DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER CAUSED AND ON ANY
 * THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT LIABILITY, OR TORT
 * (INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN ANY WAY OUT OF THE USE
 * OF THIS SOFTWARE, EVEN IF ADVISED OF THE POSSIBILITY OF SUCH DAMAGE.
 *
 * This software consists of voluntary contributions made by many individuals
 * and is licensed under the MIT license.
 */

namespace ZfSimpleAuthTest\Authentication
;

use ZfSimpleAuthTests\Bootstrap;

class AuthenticationTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var \Zend\Authentication\AuthenticationService
     */
    protected $authenticationService;

    public function setUp()
    {
        $this->authenticationService = Bootstrap::getServiceManager()->get('Zend\Authentication\AuthenticationService');
    }

    public function testCannotAuthenticateWithBadCredentials()
    {
        $authAdapter = Bootstrap::getServiceManager()->get('ZfSimpleAuth\Authentication\Adapter');
        $authAdapter->setIdentity('demo-admin');
        $authAdapter->setCredential('barbar');
        $result = $this->authenticationService->authenticate($authAdapter);
        $this->assertFalse($result->isValid());
        $this->assertNull($this->authenticationService->getIdentity());

    }

    public function testCanAuthenticateWithGoodCredentials()
    {
        $authAdapter = Bootstrap::getServiceManager()->get('ZfSimpleAuth\Authentication\Adapter');
        $authAdapter->setIdentity('demo-admin');
        $authAdapter->setCredential('foobar');
        $result = $this->authenticationService->authenticate($authAdapter);
        $this->assertTrue($result->isValid());
        $identity = $this->authenticationService->getIdentity();
        $this->assertInstanceOf('\ZfSimpleAuth\Authentication\Identity', $identity);
        /* @var \ZfSimpleAuth\Authentication\Identity $identity */
        $this->assertEquals('demo-admin', $identity->getName());
        $this->assertEquals(array('admin', 'member'), $identity->getRoles());
    }
}
