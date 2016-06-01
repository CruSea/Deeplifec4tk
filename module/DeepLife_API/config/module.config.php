<?php
/**
 * Created by PhpStorm.
 * User: BENGEOS-PC
 * Date: 3/25/2016
 * Time: 12:54 PM
 */
namespace DeepLife_API;
return array(
    'router' => array(
        'routes' => array(
            'sms_api' => array(
                'type'    => 'segment',
                'options' => array(
                    'route'    => '/deep_api',
                    'defaults' => array(
                        'controller' => 'api_controller\Controller\api',
                    ),
                ),
            ),
        ),
    ),
    'controllers' => array(
        'invokables' => array(
            'api_controller\Controller\api' => Controller\apiController::class,
        ),
    ),
    'view_manager' => array(
        'strategies' => array(
            'ViewJsonStrategy',
        ),
        'display_not_found_reason' => true,
        'display_exceptions' => true,
        'doctype' => 'HTML5',
    ),
);