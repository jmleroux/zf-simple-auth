<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2014 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

// This route is needed for the layout.
return array(
    'router' => array(
        'routes' => array(
            'home' => array(
                'type' => 'Zend\Mvc\Router\Http\Literal',
                'options' => array(
                    'route'    => '/',
                    'defaults' => array(
                        'controller' => 'Application\Controller\Index',
                        'action'     => 'index',
                    ),
                ),
            ),

        ),
    ),
    'zf-simple-auth' => array(
        'users' => array(
            'demo-admin' => array(
                'password' => 'foobar',
                'roles' => array(
                    'admin',
                    'member',
                )
            ),
            'demo-member' => array(
                'password' => 'foobaz',
                'roles' => array(
                    'member',
                )
            ),
        ),
    ),
);
