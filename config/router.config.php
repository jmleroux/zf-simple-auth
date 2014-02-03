<?php

return array(
    'routes' => array(
        'login' => array(
            'type' => 'Zend\Mvc\Router\Http\Literal',
            'options' => array(
                'route' => '/login',
                'defaults' => array(
                    'controller' => 'ZfSimpleAuth\Controller\Auth',
                    'action' => 'login',
                ),
            ),
        ),
        'logout' => array(
            'type' => 'Zend\Mvc\Router\Http\Literal',
            'options' => array(
                'route' => '/logout',
                'defaults' => array(
                    'controller' => 'ZfSimpleAuth\Controller\Auth',
                    'action' => 'logout',
                ),
            ),
        ),
    ),
);
