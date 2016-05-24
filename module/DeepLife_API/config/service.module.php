<?php
/**
 * Created by PhpStorm.
 * User: BENGEOS-PC
 * Date: 3/25/2016
 * Time: 12:55 PM
 */
namespace DeepLife_API;
return array(
    'invokables'=> array(
        'DeepLife_API\Repository\RepositoryInterface' => 'DeepLife_API\Repository\RepositoryImpl',
    ),
    'factories'=>array(
        'DeepLife_API\Service\Service' => function(\Zend\ServiceManager\ServiceLocatorInterface $serviceLocator){
            $apiService = new \DeepLife_API\Service\ServiceImpl();
            $apiService->setApiRepository($serviceLocator->get('DeepLife_API\Repository\RepositoryInterface'));
            return $apiService;
        },
    ),
    'initializers'=>array(
        function($instance,\Zend\ServiceManager\ServiceLocatorInterface $serviceLocator){
            if($instance instanceof \Zend\Db\Adapter\AdapterAwareInterface){
                $instance->setDbAdapter($serviceLocator->get('Zend\Db\Adapter\Adapter'));
            }
        }
    ),
);