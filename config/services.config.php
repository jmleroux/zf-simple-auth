<?php
return array(
    'invokables' => array(
        'Zend\Authentication\AuthenticationService' => 'Zend\Authentication\AuthenticationService',
    ),
    'factories' => array(
        'ZfSimpleAuth\Authentication\Adapter' => 'ZfSimpleAuth\Authentication\AuthenticationFactory',
    ),
);
