<?php
namespace ZfSimpleAuth\Authentication;

use Zend\Authentication\Adapter\AbstractAdapter;
use Zend\Authentication\Adapter\Exception;
use Zend\Authentication\Result as AuthenticationResult;

class PhpArrayAdapter extends AbstractAdapter
{
    /**
     * @var array
     */
    protected $users;

    /**
     * Sets adapter options
     *
     * @param array $users
     */
    public function __construct(array $users)
    {
        $this->users = $users;
    }

    /**
     * Defined by Zend\Authentication\Adapter\AdapterInterface
     *
     * @throws Exception\ExceptionInterface
     * @return AuthenticationResult
     */
    public function authenticate()
    {
        $users = $this->users;

        $result = array(
            'code'  => AuthenticationResult::FAILURE,
            'identity' => $this->identity,
            'messages' => array()
        );

        if (!array_key_exists($this->identity, $users)) {
            $result['code'] = AuthenticationResult::FAILURE_IDENTITY_NOT_FOUND;
            $result['messages'][] = "Username '$this->identity' not found";
        }
        elseif ($users[$this->identity]['password'] == $this->credential) {
            $identity = new Identity();
            $identity->setName($this->identity);
            $identity->setRoles($users[$this->identity]['roles']);
            $result['identity'] = $identity;
            $result['code'] = AuthenticationResult::SUCCESS;
        }
        else {
            $result['code'] = AuthenticationResult::FAILURE_CREDENTIAL_INVALID;
            $result['messages'][] = 'Incorrect password';
        }

        return new AuthenticationResult($result['code'], $result['identity'], $result['messages']);
    }
}
