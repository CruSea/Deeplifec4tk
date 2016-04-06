<?php
return array(

    'router' => array(
        'routes' => array(
            'users' => array(
                'type'    => 'Literal',
                'options' => array(
                    'route'    => '/users',
                    'defaults' => array(
                        '__NAMESPACE__' => 'SamUser\Controller',
                        'controller'    => 'Users',
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
            ),
            'dashboard' => array(
                'type'    => 'Literal',
                'options' => array(
                    'route'    => '/dashboard',
                    'defaults' => array(
                        '__NAMESPACE__' => 'SamUser\Controller',
                        'controller'    => 'dashboard',
                        'action'        => 'index',
                    ),
                ),
                'may_terminate' => true,
                'child_routes' => array(
                        'adddisciple' => array(
                            'type' => 'Literal',
                            'options' => array(
                                'route' => '/adddisciple',
                                'defaults' => array(
                                    'controller' => 'dashboard',
                                    'action'     => 'adddisciple',
                                ),
                            ),
                        ),
                      
                    'listdisciple' => array(
                        'type' => 'Literal',
                        'options' => array(
                            'route' => '/listdisciple   ',
                            'defaults' => array(
                                'controller' => 'dashboard',
                                'action'     => 'listdisciple',
                            ),
                        ),
                    ),
                    'updateinfo' => array(
                        'type' => 'Literal',
                        'options' => array(
                            'route' => '/updateinfo',
                            'defaults' => array(
                                'controller' => 'dashboard',
                                'action'     => 'updateinfo',
                            ),
                        ),
                    ),
                      
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
            ),
            'resource' => array(
                'type'    => 'Literal',
                'options' => array(
                    'route'    => '/resource',
                    'defaults' => array(
                        '__NAMESPACE__' => 'SamUser\Controller',
                        'controller'    => 'Resource',
                        'action'        => 'index',
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
                                'action'     => 'download1',
                            ),
                        ),
                    ),
                    'download2' => array(
                        'type' => 'Literal',
                        'options' => array(
                            'route' => '/download2',
                            'defaults' => array(
                                'controller' => 'resource',
                                'action'     => 'download2',
                            ),
                        ),
                    ),
                    'download3' => array(
                        'type' => 'Literal',
                        'options' => array(
                            'route' => '/download3',
                            'defaults' => array(
                                'controller' => 'resource',
                                'action'     => 'download3',
                            ),
                        ),
                    ),
                    'download4' => array(
                        'type' => 'Literal',
                        'options' => array(
                            'route' => '/download4',
                            'defaults' => array(
                                'controller' => 'resource',
                                'action'     => 'download4',
                            ),
                        ),
                    ),
                    'download5' => array(
                        'type' => 'Literal',
                        'options' => array(
                            'route' => '/download5',
                            'defaults' => array(
                                'controller' => 'resource',
                                'action'     => 'download5',
                            ),
                        ),
                    ),
                    'download6' => array(
                        'type' => 'Literal',
                        'options' => array(
                            'route' => '/download6',
                            'defaults' => array(
                                'controller' => 'resource',
                                'action'     => 'download6',
                            ),
                        ),
                    ),
                    'listdisciple' => array(
                        'type' => 'Literal',
                        'options' => array(
                            'route' => '/listdisciple   ',
                            'defaults' => array(
                                'controller' => 'dashboard',
                                'action'     => 'listdisciple',
                            ),
                        ),
                    ),
                   

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
            ),
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
            ),
            'roles' => array(
                'type'    => 'Literal',
                'options' => array(
                    'route'    => '/roles',
                    'defaults' => array(
                        '__NAMESPACE__' => 'SamUser\Controller',
                        'controller'    => 'Roles',
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

        ),
    ),
    'view_manager' => array(
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
        'user_entity_class'       => 'SamUser\Entity\User',
        // telling ZfcUserDoctrineORM to skip the entities it defines
        'enable_default_entities' => false,
    ),

    'bjyauthorize' => array(
        // Using the authentication identity provider, which basically reads the roles from the auth service's identity
        'identity_provider' => 'BjyAuthorize\Provider\Identity\AuthenticationIdentityProvider',

        'role_providers'        => array(
            // using an object repository (entity repository) to load all roles into our ACL
            'BjyAuthorize\Provider\Role\ObjectRepositoryProvider' => array(
                'object_manager'    => 'doctrine.entitymanager.orm_default',
                'role_entity_class' => 'SamUser\Entity\Role',
            ),
        ),
    ),
);


