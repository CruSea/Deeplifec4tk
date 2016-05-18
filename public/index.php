<?php
error_reporting(1);
/**
 * This makes our life easier when dealing with paths. Everything is relative
 * to the application root now.
 */
defined('PUBLIC_PATH')|| define('PUBLIC_PATH', realpath(dirname(__FILE__)));
define('REQUEST_MICROTIME', microtime(true));
chdir(dirname(__DIR__));



// Decline static file requests back to the PHP built-in webserver
if (php_sapi_name() === 'cli-server') {
    $path = realpath(__DIR__ . parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH));
    if (__FILE__ !== $path && is_file($path)) {
        return false;
    }
    unset($path);
}

// Setup autoloading
require 'init_autoloader.php';
$detect = new Mobile_Detect;
 $deviceType = ($detect->isMobile() ? ($detect->isTablet()? 'computer' :'phone') : 'computer');
 
if($deviceType !== 'computer' && $_SERVER['REQUEST_URI']!='/mobileapp' ){
   $actual_link = "http://$_SERVER[HTTP_HOST]/mobileapp";
  header("Location:".$actual_link); /* Redirect browser */
/* Make sure that code below does not get executed when we redirect. */
exit;
}

// Run the application!
Zend\Mvc\Application::init(require 'config/application.config.php')->run();



