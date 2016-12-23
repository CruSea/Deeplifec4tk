<?php
/**
 * Local Configuration Override
 *
 * This configuration override file is for overriding environment-specific and
 * security-sensitive configuration information. Copy this file without the
 * .dist extension at the end and populate values as needed.
 *
 * @NOTE: This file is ignored from Git by default with the .gitignore included
 * in ZendSkeletonApplication. This is a good practice, as it prevents sensitive
 * credentials from accidentally being committed into version control.
 */

return array(
    'db' => array(
        'driver' => 'Pdo',
        'dsn' => 'mysql:dbname=stagingdeeplife;
        host=localhost',
        'username' => 'root',
        'password' => '',
        'driver_options' => array(
            PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES \'UTF8\''
        ),
    ),

    'roles' => array(
        'USER' => 1,
        'SUPERADMIN' => 2,
        'AREAADMIN' => 3,
        'COUNTRYADMIN' => 4,

    ),

    'locale' => array(
        'default' => 'en_US',
        'available' => array(
            'de_DE' => 'Deutsch',
            'nl_NL' => 'Dutch',
            'en_US' => 'English',
            'fr_FR' => 'French',
        ),
    ),

    'doctrine' => array(
        'connection' => array(
            'orm_default' => array(
                'driverClass' => 'Doctrine\DBAL\Driver\PDOMySql\Driver',
                'params' => array(
                    'host' => '127.0.0.1',
                    'port' => '3306',
                    'user' => 'root',
                    'password' => '',
                    'dbname' => 'deeplife',
                    'driverOptions' => array(1002 => 'SET NAMES utf8')
                ),
            ),
        ),
    ),

    'service_manager' => array(
        'factories' => array(
            'Zend\Db\Adapter\Adapter' => 'Zend\Db\Adapter\AdapterServiceFactory',

        ),
    ),
);
