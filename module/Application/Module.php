<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2015 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Application;

use Zend\Mvc\ModuleRouteListener;
use Zend\Mvc\MvcEvent;

class Module
{
    public function onBootstrap(MvcEvent $e)
    {
    
    
      
        $applicaton = $e->getApplication()->getServiceManager();
        // Just a call to the translator, nothing special!
        $applicaton->get('translator');
        $this->initTranslator($e);
    
        $eventManager        = $e->getApplication()->getEventManager();
        $moduleRouteListener = new ModuleRouteListener();
        $moduleRouteListener->attach($eventManager);
    
    
    
    }

    public function getConfig()
    {
        return include __DIR__ . '/config/module.config.php';
    }

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
    
    
     protected function initTranslator(MvcEvent $event)
    {
        
       
        $serviceManager = $event->getApplication()->getServiceManager();
       $auth = $serviceManager->get('zfcuser_auth_service');
       $language='en_US';
       if ($auth->hasIdentity()) {
        $language=$auth->getIdentity()->userlocale;
        }
     
        $translator = $serviceManager->get('translator');
        $translator->setLocale($language)
            ->setFallbackLocale('en_US');
          
    }
}
