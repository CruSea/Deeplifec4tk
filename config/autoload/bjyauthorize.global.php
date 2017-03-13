<?php
/**
 * BjyAuthorize Module (https://github.com/bjyoungblood/BjyAuthorize)
 *
 * @link https://github.com/bjyoungblood/BjyAuthorize for the canonical source repository
 * @license http://framework.zend.com/license/new-bsd New BSD License
 */

return array(
    'bjyauthorize' => array(

        // set the 'guest' role as default (must be defined in a role provider)
        'default_role' => 'guest',

//        'unauthorized_strategy' => 'BjyAuthorize\View\RedirectionStrategy',

        /* If you only have a default role and an authenticated role, you can
         * use the 'AuthenticationIdentityProvider' to allow/restrict access
         * with the guards based on the state 'logged in' and 'not logged in'.
         *
         * 'default_role'       => 'guest',         // not authenticated
         * 'authenticated_role' => 'user',          // authenticated
         * 'identity_provider'  => 'BjyAuthorize\Provider\Identity\AuthenticationIdentityProvider',
         */

        /* role providers simply provide a list of roles that should be inserted
         * into the Zend\Acl instance. the module comes with two providers, one
         * to specify roles in a config file and one to load roles using a
         * Zend\Db adapter.
         */
        'role_providers' => array(

            /* here, 'guest' and 'user are defined as top-level roles, with
             * 'admin' inheriting from user
             */
            /*'BjyAuthorize\Provider\Role\Config' => array(
                'guest' => array(),
                'user'  => array('children' => array(
                    'admin' => array(),
                )),
            ),*/
        ),

        // resource providers provide a list of resources that will be tracked
        // in the ACL. like roles, they can be hierarchical
        'resource_providers' => array(
            'BjyAuthorize\Provider\Resource\Config' => array(
            ),
        ),

        /* rules can be specified here with the format:
         * array(roles (array), resource, [privilege (array|string), assertion])
         * assertions will be loaded using the service manager and must implement
         * Zend\Acl\Assertion\AssertionInterface.
         * *if you use assertions, define them using the service manager!*
         */
        'rule_providers' => array(
            'BjyAuthorize\Provider\Rule\Config' => array(
                'allow' => array(
                    // ...
                ),

                // Don't mix allow/deny rules if you are using role inheritance.
                // There are some weird bugs.
                'deny' => array(
                    // ...
                ),
            ),
        ),

        /* Currently, only controller and route guards exist
         *
         * Consider enabling either the controller or the route guard depending on your needs.
         */
        'guards' => array(
            /* If this guard is specified here (i.e. it is enabled), it will block
             * access to all controllers and actions unless they are specified here.
             * You may omit the 'action' index to allow access to the entire controller
             */
//            'BjyAuthorize\Guard\Controller' => array(
//                //array('controller' => 'index', 'action' => 'index', 'roles' => array('user')),
//                //array('controller' => 'index', 'action' => 'stuff', 'roles' => array('user')),
//
//                // For ZfcUser module
//                array(
//                    'controller' => 'zfcuser',
//                    'roles' => array('guest')
//                ),
//
//                array(
//                    'controller' => 'zfcuser',
//                    'action' => array('index', 'logout'),
//                    'roles' => array('user')
//                ),
//
//                // Below is the default index action used by the ZendSkeletonApplication
//                array('controller' => 'Application\Controller\Index', 'roles' => array('guest', 'user')),
//            ),

            /* If this guard is specified here (i.e. it is enabled), it will block
             * access to all routes unless they are specified here.
             */
            'BjyAuthorize\Guard\Route' => array(
                array('route' => 'zfcuser', 'roles' => array('guest', 'user')),
                array('route' => 'zfcuser/logout', 'roles' => array('user')),
                array('route' => 'zfcuser/login', 'roles' => array('guest', 'user')),
                array('route' => 'zfcuser/register', 'roles' => array('guest', 'user')),

                // Below is the default index action used by the ZendSkeletonApplication
                array('route' => 'home', 'roles' => array('guest', 'user')),
                array('route' => '/', 'roles' => array('guest', 'user')),
                array('route' => 'news', 'roles' => array('guest', 'user')),
                array('route' => 'application', 'roles' => array('guest', 'user')),
                array('route' => 'application/default', 'roles' => array('guest', 'user')), // Change language

                // User module
                array('route' => 'users', 'roles' => array('user')),
                array('route' => 'users/default', 'roles' => array('user')),
                array('route' => 'usersApi', 'roles' => array('user')),             // User data
                array('route' => 'roles', 'roles' => array('user')),
                array('route' => 'roles/default', 'roles' => array('user')),
                array('route' => 'rolesApi', 'roles' => array('user')),             // Role data
                array('route' => 'accesses', 'roles' => array('user')),
                array('route' => 'accesses/default', 'roles' => array('user')),
                array('route' => 'accessesApi', 'roles' => array('user')),          // Access data
                array('route' => 'contacts', 'roles' => array('user')),
                array('route' => 'contacts/default', 'roles' => array('user')),

                // Dashboard module
                array('route' => 'dashboard', 'roles' => array('user')),
                array('route' => 'dashboard/default', 'roles' => array('user')),


                // resource module
                array('route' => 'resource', 'roles' => array('user')),
                array('route' => 'resource/default', 'roles' => array('user')),

                // tree module
                array('route' => 'tree', 'roles' => array('user')),
                array('route' => 'tree/default', 'roles' => array('user')),

                //news module
                array('route' => 'news', 'roles' => array('user')),
                array('route' => 'news/paged', 'roles' => array('user')),
                array('route' => 'news/posts/:categorySlug/:postSlug', 'roles' => array('user')),
                array('route' => 'edit', 'roles' => array('user')),
                array('route' => 'delete', 'roles' => array('user')),
                array('route' => 'display-post', 'roles' => array('user')),
                array('route' => 'news/default', 'roles' => array('user')),



            ),
        ),
    ),
);
