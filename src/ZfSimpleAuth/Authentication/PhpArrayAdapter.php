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
