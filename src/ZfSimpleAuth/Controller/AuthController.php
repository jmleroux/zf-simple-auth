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

namespace ZfSimpleAuth\Controller;

use Zend\Authentication\Adapter\AbstractAdapter;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\Session\Container;
use Zend\View\Model\ViewModel;
use Zend\Authentication\AuthenticationService;

/**
 * Class AuthController
 * @package ZfSimpleAuth\Controller
 */
class AuthController extends AbstractActionController
{
    /**
     * @var AbstractAdapter
     */
    protected $authAdapter;

    /**
     * @param AbstractAdapter $adapter
     */
    public function __construct(AbstractAdapter $adapter)
    {
        $this->authAdapter = $adapter;
    }

    /**
     * @return ViewModel
     */
    public function loginAction()
    {
        $prg = $this->prg('login', true);

        if ($prg instanceof \Zend\Http\PhpEnvironment\Response) {
            return $prg;
        } elseif ($prg === false) {
            return new ViewModel();
        }

        $username = $prg['username'];
        $password = $prg['pwd'];

        // instantiate the authentication service
        $auth = new AuthenticationService();

        // Set up the authentication adapter
        $this->authAdapter->setIdentity($username);
        $this->authAdapter->setCredential($password);

        // Attempt authentication, saving the result
        $result = $auth->authenticate($this->authAdapter);
        if ($result->isValid()) {
            $this->flashMessenger()->addSuccessMessage('Successful login');
        } else {
            $this->flashMessenger()->addErrorMessage('Invalid informations');
        }

        return $this->redirect()->toRoute('login');
    }

    public function logoutAction()
    {
        $auth = new AuthenticationService();
        $auth->clearIdentity();
        return $this->redirect()->toRoute('login');
    }
}
