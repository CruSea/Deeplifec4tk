<?php
/**
 * Created by PhpStorm.
 * User: BENGEOS-PC
 * Date: 3/25/2016
 * Time: 1:21 PM
 */

namespace DeepLife_API;


use Zend\ModuleManager\Feature\AutoloaderProviderInterface;
use Zend\ModuleManager\Feature\ConfigProviderInterface;
use Zend\ModuleManager\Feature\ServiceProviderInterface;

class Module implements ConfigProviderInterface,ServiceProviderInterface,AutoloaderProviderInterface
{
    public function getAutoloaderConfig()
    {
        return array(
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    __NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__,
                ),
            ),
        );
    }

    public function getConfig()
    {
        return include __DIR__.'/config/module.config.php';
    }
    public function getServiceConfig()
    {
        return include __DIR__.'/config/service.module.php';
    }

}