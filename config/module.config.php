<?php
/**
 * CoolMS2 User Extensions Module (http://www.coolms.com/)
 *
 * @link      http://github.com/coolms/user-ext for the canonical source repository
 * @copyright Copyright (c) 2006-2015 Altgraphic, ALC (http://www.altgraphic.com)
 * @license   http://www.coolms.com/license/new-bsd New BSD License
 * @author    Dmitry Popov <d.popov@altgraphic.com>
 */

namespace CmsUserExt;

return [
    'cmspermissions' => [
        'acl' => [
            'guards' => [
                'CmsAcl\Guard\Route' => [
                    ['route' => 'cms-user/ext', 'roles' => ['user'], 'assertion' => ['CmsUserExt\Acl\UserActionAssertion']],
                    ['route' => 'cms-admin/user/ext', 'roles' => ['admin']],
                ],
            ],
            'assertion_manager' => [
                'factories' => [
                    'CmsUserExt\Acl\UserActionAssertion' => 'CmsUserExt\Factory\Acl\UserActionAssertionFactory',
                ],
            ],
        ],
    ],
    'controllers' => [
        'aliases' => [
            'CmsUserExt\Controller\Admin' => 'CmsUserExt\Mvc\Controller\AdminController',
            'CmsUserExt\Controller\User' => 'CmsUserExt\Mvc\Controller\UserController',
        ],
        'factories' => [
            'CmsUserExt\Mvc\Controller\UserController' => 'CmsUserExt\Factory\Controller\UserControllerFactory',
        ],
        'invokables' => [
            'CmsUserExt\Mvc\Controller\AdminController' => 'CmsUserExt\Mvc\Controller\AdminController',
        ],
    ],
    'navigation' => [
        'cmsuser' => [
            [
                'label' => 'Add individual data',
                'text_domain' => __NAMESPACE__,
                'route' => 'cms-user/ext',
                'params' => ['action' => 'create'],
                'resource' => 'route/cms-user/ext',
                'privilege' => 'create',
                'order' => 650,
                'twbs' => [
                    'icon' => [
                        'type' => 'fa',
                        'content' => 'pencil',
                        'placement' => 'prepend',
                        'tagName' => 'i',
                    ],
                ],
            ],
            [
                'label' => 'Edit individual data',
                'text_domain' => __NAMESPACE__,
                'route' => 'cms-user/ext',
                'params' => ['action' => 'update'],
                'resource' => 'route/cms-user/ext',
                'privilege' => 'update',
                'order' => 650,
                'twbs' => [
                    'icon' => [
                        'type' => 'fa',
                        'content' => 'pencil',
                        'placement' => 'prepend',
                        'tagName' => 'i',
                    ],
                ],
            ],
            [
                'order' => 700,
                'uri' => '',
                'class' => 'divider',
            ],
        ],
    ],
    'router' => [
        'routes' => [
            'cms-user' => [
                'child_routes' => [
                    'ext' => [
                        'type' => 'Segment',
                        'options' => [
                            'route' => '/ext[/:action]',
                            'constraints' => [
                                'action' => '[a-zA-Z\-]*',
                            ],
                            'defaults' => [
                                '__NAMESPACE__' => 'CmsUserExt\Controller',
                                'controller' => 'User',
                                'action' => 'index',
                            ],
                        ],
                    ],
                ],
            ],
            'cms-admin' => [
                'child_routes' => [
                    'user' => [
                        'child_routes' => [
                            'ext' => [
                                'type' => 'Segment',
                                'options' => [
                                    'route' => '/ext[/:controller[/:action[/:id]]]',
                                    'constraints' => [
                                        'controller' => '[a-zA-Z\-]*',
                                        'action' => '[a-zA-Z\-]*',
                                        'id' => '[a-zA-Z0-9\-]*',
                                    ],
                                    'defaults' => [
                                        '__NAMESPACE__' => 'CmsUserExt\Controller',
                                        'controller' => 'Admin',
                                        'action' => 'index',
                                    ],
                                ],
                            ],
                        ],
                    ],
                ],
            ],
        ],
    ],
    'translator' => [
        'translation_file_patterns' => [
            [
                'type' => 'gettext',
                'base_dir' => __DIR__ . '/../language',
                'pattern' => '%s.mo',
                'text_domain' => __NAMESPACE__,
            ],
        ],
    ],
    'view_manager' => [
        'template_path_stack' => [
            __NAMESPACE__ => __DIR__ . '/../view',
        ],
    ],
];
