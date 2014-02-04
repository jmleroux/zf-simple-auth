<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2013 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace ZfSimpleAuth\Controller;

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
        $authAdapter = $this->getServiceLocator()->get('ZfSimpleAuth\Authentication\Adapter');
        $authAdapter->setIdentity($username);
        $authAdapter->setCredential($password);

        // Attempt authentication, saving the result
        $result = $auth->authenticate($authAdapter);
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
