<?php
return array(
    'router' => include __DIR__ . '/router.config.php',
    'service_manager' => include __DIR__ . '/services.config.php',
    'view_manager' => array(
        'template_map' => array(
            'layout/layout'           => __DIR__ . '/../view/layout/layout.phtml',
        ),
        'template_path_stack' => array(
            __DIR__ . '/../view',
        ),
    ),
);
