<?php

namespace LandingPage;

return array(
    'router' => array(
        'routes' => array(
            'generic' => array(
                'type' => 'Literal',
                'options' => array(
                    'route' => '/',
                    'defaults' => array(
                        /*
                        '__NAMESPACE__' => 'LandingPage\Controller',
                        'controller' => 'Index',
                        'action' => 'index',
                        */

                        'controller' => 'zfcuser',
                        'action' => 'login',
                        //'action' => 'register',
                        //'action' => 'changepassword',

                    ),
                ),
            ),

            'sea' => array(
                'type'    => 'Literal',
                'options' => array(
                    'route'    => '/sea',
                    'defaults' => array(
                        '__NAMESPACE__' => 'LandingPage\Controller',
                        'controller'    => 'Index',
                        'action'        => 'sea',
                    ),
                ),
            ),


        ),
    ),

    'controllers' => array(
        'invokables' => array(
            'LandingPage\Controller\Index' => Controller\IndexController::class
        ),
    ),
    'view_manager' => array(
        'template_map' => array(
            'layout/layout' => __DIR__ . '/../view/layout/layout.phtml',
            'layout/generic' => __DIR__ . '/../view/layout/generic.phtml',
            'layout/sea' => __DIR__ . '/../view/layout/sea.phtml',
        ),
        'template_path_stack' => array(
            __DIR__ . '/../view',
        ),
    ),
);
