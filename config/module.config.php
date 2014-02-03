<?php
return array(
    'router' => include __DIR__ . '/router.config.php',
    'controllers' => include __DIR__ . '/controllers.config.php',
    'service_manager' => include __DIR__ . '/services.config.php',
    'view_manager' => array(
        'template_map' => array(
//            'layout/layout'           => __DIR__ . '/../view/layout/layout.phtml',
        ),
        'template_path_stack' => array(
            __DIR__ . '/../view',
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
