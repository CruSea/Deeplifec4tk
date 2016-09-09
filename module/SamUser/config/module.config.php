<?php
return array(

    'router' => array(
        'routes' => array(
            'users' => array(
                'type' => 'Literal',
                'options' => array(
                    'route' => '/users',
                    'defaults' => array(
                        '__NAMESPACE__' => 'SamUser\Controller',
                        'controller' => 'Users',
                        'action' => 'index',
                    ),
                ),
                'may_terminate' => true,
                'child_routes' => array(
                    'default' => array(
                        'type' => 'Segment',
                        'options' => array(
                            'route' => '/[:action[/:id]]',
                            'constraints' => array(
                                'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'id' => '[0-9]+',
                            ),
                            'defaults' => array(),
                        ),
                    ),
                ),
            ),


            'dashboard' => array(
                'type' => 'segment',
                'options' => array(
                    'route' => '/dashboard[/:action][/:id]',
                    'constraints' => array(
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id' => '[0-9]+',
                    ),
                    'defaults' => array(
                        'controller' => 'SamUser\Controller\dashboard',
                        'action' => 'index',
                    ),
                ),
            ),


            'resource' => array(
                'type' => 'Literal',
                'options' => array(
                    'route' => '/resource',
                    'defaults' => array(
                        '__NAMESPACE__' => 'SamUser\Controller',
                        'controller' => 'Resource',
                        'action' => 'index',
                    ),
                ),
                'may_terminate' => true,
                'child_routes' => array(
                    'download1' => array(
                        'type' => 'Literal',
                        'options' => array(
                            'route' => '/download1',
                            'defaults' => array(
                                'controller' => 'resource',
                                'action' => 'download1',
                            ),
                        ),
                    ),
                    'download2' => array(
                        'type' => 'Literal',
                        'options' => array(
                            'route' => '/download2',
                            'defaults' => array(
                                'controller' => 'resource',
                                'action' => 'download2',
                            ),
                        ),
                    ),
                    'download3' => array(
                        'type' => 'Literal',
                        'options' => array(
                            'route' => '/download3',
                            'defaults' => array(
                                'controller' => 'resource',
                                'action' => 'download3',
                            ),
                        ),
                    ),
                    'download4' => array(
                        'type' => 'Literal',
                        'options' => array(
                            'route' => '/download4',
                            'defaults' => array(
                                'controller' => 'resource',
                                'action' => 'download4',
                            ),
                        ),
                    ),
                    'download5' => array(
                        'type' => 'Literal',
                        'options' => array(
                            'route' => '/download5',
                            'defaults' => array(
                                'controller' => 'resource',
                                'action' => 'download5',
                            ),
                        ),
                    ),
                    'download6' => array(
                        'type' => 'Literal',
                        'options' => array(
                            'route' => '/download6',
                            'defaults' => array(
                                'controller' => 'resource',
                                'action' => 'download6',
                            ),
                        ),
                    ),
                    'listdisciple' => array(
                        'type' => 'Literal',
                        'options' => array(
                            'route' => '/listdisciple   ',
                            'defaults' => array(
                                'controller' => 'dashboard',
                                'action' => 'listdisciple',
                            ),
                        ),
                    ),


                    'default' => array(
                        'type' => 'Segment',
                        'options' => array(
                            'route' => '/[:action[/:id]]',
                            'constraints' => array(
                                'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'id' => '[0-9]+',
                            ),
                            'defaults' => array(),
                        ),
                    ),
                ),
            ),

            'tree' => array(
                'type' => 'segment',
                'options' => array(
                    'route' => '/tree[/:action][/:id]',
                    'constraints' => array(
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id' => '[0-9]+',
                    ),
                    'defaults' => array(
                        'controller' => 'SamUser\Controller\Tree',
                        'action' => 'index',
                    ),
                ),
            ),

            'disciples' => array(
                'type' => 'segment',
                'options' => array(
                    'route' => '/disciples[/:action][/:id]',
                    'constraints' => array(
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id' => '[0-9]+',
                    ),
                    'defaults' => array(
                        'controller' => 'SamUser\Controller\Disciples',
                        'action' => 'index',
                    ),
                ),
            ),


            /*
               'tree' => array(
                   'type'    => 'Literal',
                   'options' => array(
                       'route'    => '/tree',
                       'defaults' => array(
                           '__NAMESPACE__' => 'SamUser\Controller',
                           'controller'    => 'Tree',
                           'action'        => 'index',
                       ),
                   ),
                   'may_terminate' => true,
                   'child_routes' => array(

                       'default' => array(
                           'type'    => 'Segment',
                           'options' => array(
                               'route'    => '/[:action[/:id]]',
                               'constraints' => array(
                                   'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                   'id'     => '[0-9]+',
                               ),
                               'defaults' => array(
                               ),
                           ),
                       ),
                   ),
               ), */


            'roles' => array(
                'type' => 'Literal',
                'options' => array(
                    'route' => '/roles',
                    'defaults' => array(
                        '__NAMESPACE__' => 'SamUser\Controller',
                        'controller' => 'Roles',
                        'action' => 'index',
                    ),
                ),
                'may_terminate' => true,
                'child_routes' => array(
                    'default' => array(
                        'type' => 'Segment',
                        'options' => array(
                            'route' => '/[:action[/:id]]',
                            'constraints' => array(
                                'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'id' => '[0-9]+',
                            ),
                            'defaults' => array(),
                        ),
                    ),
                ),
            ),
        ),


    ),

    'controllers' => array(
        'invokables' => array(
            'SamUser\Controller\Users' => 'SamUser\Controller\UsersController',
            'SamUser\Controller\Roles' => 'SamUser\Controller\RolesController',
            'SamUser\Controller\Dashboard' => 'SamUser\Controller\DashboardController',
            'SamUser\Controller\Resource' => 'SamUser\Controller\ResourceController',
            'SamUser\Controller\Tree' => 'SamUser\Controller\TreeController',
            'SamUser\Controller\Disciples' => 'SamUser\Controller\DisciplesController',
        ),
    ),
    'view_manager' => array(

        'template_map' => array(
            'chart' => __DIR__ . '/../view/sam-user/tree/chart.phtml',

        ),
        'template_path_stack' => array(
            __DIR__ . '/../view',
        ),
        'strategies' => array(
            'ViewJsonStrategy',
        ),
    ),
    'doctrine' => array(
        'driver' => array(
            // overriding zfc-user-doctrine-orm's config
            'zfcuser_entity' => array(
                'class' => 'Doctrine\ORM\Mapping\Driver\AnnotationDriver',
                'paths' => __DIR__ . '/../src/SamUser/Entity',
            ),

            'orm_default' => array(
                'drivers' => array(
                    'SamUser\Entity' => 'zfcuser_entity',
                ),
            ),
        ),
    ),

    'zfcuser' => array(
        // telling ZfcUser to use our own class
        'user_entity_class' => 'SamUser\Entity\User',
        // telling ZfcUserDoctrineORM to skip the entities it defines
        'enable_default_entities' => false,
    ),


    /*
    
    'doctrine'=>array(
'configuration' => array(
        'orm_default' => array(
            'datetime_functions' => array(
                'date' => 'DoctrineExtensions\Query\Mysql\Date',
                'date_format' => 'DoctrineExtensions\Query\Mysql\DateFormat',
                'dateadd' => 'DoctrineExtensions\Query\Mysql\DateAdd',
                'datediff' => 'DoctrineExtensions\Query\Mysql\DateDiff',
                'day' => 'DoctrineExtensions\Query\Mysql\Day',
                'dayname' => 'DoctrineExtensions\Query\Mysql\DayName',
                'last_day' => 'DoctrineExtensions\Query\Mysql\LastDay',
                'minute' => 'DoctrineExtensions\Query\Mysql\Minute',
                'second' => 'DoctrineExtensions\Query\Mysql\Second',
                'strtodate' => 'DoctrineExtensions\Query\Mysql\StrToDate',
                'time' => 'DoctrineExtensions\Query\Mysql\Time',
                'timestampadd' => 'DoctrineExtensions\Query\Mysql\TimestampAdd',
                'timestampdiff' => 'DoctrineExtensions\Query\Mysql\TimestampDiff',
                'week' => 'DoctrineExtensions\Query\Mysql\Week',
                'weekday' => 'DoctrineExtensions\Query\Mysql\WeekDay',
                'year' => 'DoctrineExtensions\Query\Mysql\Year',
            ),
            'numeric_functions' => array(
                'acos'  => 'DoctrineExtensions\Query\Mysql\Acos',
                'asin' => 'DoctrineExtensions\Query\Mysql\Asin',
                'atan2' => 'DoctrineExtensions\Query\Mysql\Atan2',
                'atan' => 'DoctrineExtensions\Query\Mysql\Atan',
                'cos' => 'DoctrineExtensions\Query\Mysql\Cos',
                'cot' => 'DoctrineExtensions\Query\Mysql\Cot',
                'hour' => 'DoctrineExtensions\Query\Mysql\Hour',
                'pi' => 'DoctrineExtensions\Query\Mysql\Pi',
                'power' => 'DoctrineExtensions\Query\Mysql\Power',
                'quarter' => 'DoctrineExtensions\Query\Mysql\Quarter',
                'rand' => 'DoctrineExtensions\Query\Mysql\Rand',
                'round' => 'DoctrineExtensions\Query\Mysql\Round',
                'sin' => 'DoctrineExtensions\Query\Mysql\Sin',
                'std' => 'DoctrineExtensions\Query\Mysql\Std',
                'tan' => 'DoctrineExtensions\Query\Mysql\Tan',
            ),
            'string_functions' => array(
                'binary' => 'DoctrineExtensions\Query\Mysql\Binary',
                'char_length' => 'DoctrineExtensions\Query\Mysql\CharLength',
                'concat_ws' => 'DoctrineExtensions\Query\Mysql\ConcatWs',
                'countif' => 'DoctrineExtensions\Query\Mysql\CountIf',
                'crc32' => ' DoctrineExtensions\Query\Mysql\Crc32',
                'degrees' => 'DoctrineExtensions\Query\Mysql\Degrees',
                'field' => 'DoctrineExtensions\Query\Mysql\Field',
                'find_in_set' => 'DoctrineExtensions\Query\Mysql\FindInSet',
                'group_concat' => 'DoctrineExtensions\Query\Mysql\GroupConcat',
                'ifelse' => 'DoctrineExtensions\Query\Mysql\IfElse',
                'ifnull' => 'DoctrineExtensions\Query\Mysql\IfNull',
                'match_against' => 'DoctrineExtensions\Query\Mysql\MatchAgainst',
                'md5' => 'DoctrineExtensions\Query\Mysql\Md5',
                'month' => 'DoctrineExtensions\Query\Mysql\Month',
                'monthname' => 'DoctrineExtensions\Query\Mysql\MonthName',
                'nullif' => 'DoctrineExtensions\Query\Mysql\NullIf',
                'radians' => 'DoctrineExtensions\Query\Mysql\Radians',
                'regexp' => 'DoctrineExtensions\Query\Mysql\Regexp',
                'replace' => 'DoctrineExtensions\Query\Mysql\Replace',
                'sha1' => 'DoctrineExtensions\Query\Mysql\Sha1',
                'sha2' => 'DoctrineExtensions\Query\Mysql\Sha2',
                'soundex' => 'DoctrineExtensions\Query\Mysql\Soundex',
                'uuid_short' => 'DoctrineExtensions\Query\Mysql\UuidShort',
            ),

        )
    )
), */
);


