<?php

namespace News;

return array(
    'invokables' => array(
        'News\Repository\PostRepository' => 'News\Repository\PostRepositoryImpl',
    ),

    'factories' => array(
        'News\Service\BlogService' => function (\Zend\ServiceManager\ServiceLocatorInterface $serviceLocator) {
            $blogService = new \News\Service\BlogServiceImpl();
            $blogService->setBlogRepository($serviceLocator->get('News\Repository\PostRepository'));

            return $blogService;
        },
    ),

    'initializers' => array(
        function ($instance, \Zend\ServiceManager\ServiceLocatorInterface $serviceLocator) {
            if ($instance instanceof \Zend\Db\Adapter\AdapterAwareInterface) {
                $instance->setDbAdapter($serviceLocator->get('Zend\Db\Adapter\Adapter'));
            }
        },
    ),
);