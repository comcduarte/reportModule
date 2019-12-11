<?php 

use Report\Controller\ConfigController;
use Report\Controller\ReportController;
use Report\Controller\Factory\ConfigControllerFactory;
use Report\Controller\Factory\ReportControllerFactory;
use Report\Form\ReportForm;
use Report\Form\Factory\ReportFormFactory;
use Report\Service\Factory\ReportModelPrimaryAdapterFactory;
use Zend\Router\Http\Literal;
use Zend\Router\Http\Segment;

return [
    'router' => [
        'routes' => [
            'reports' => [
                'type' => Literal::class,
                'priority' => 1,
                'options' => [
                    'route' => '/reports',
                    'defaults' => [
                        'action' => 'index',
                        'controller' => ReportController::class,
                    ],
                ],
                'may_terminate' => TRUE,
                'child_routes' => [
                    'config' => [
                        'type' => Segment::class,
                        'options' => [
                            'route' => '/config[/:action]',
                            'defaults' => [
                                'action' => 'index',
                                'controller' => ConfigController::class,
                            ],
                        ],
                    ],
                    'default' => [
                        'type' => Segment::class,
                        'priority' => -100,
                        'options' => [
                            'route' => '/[:action[/:uuid]]',
                            'defaults' => [
                                'action' => 'index',
                                'controller' => ReportController::class,
                            ],
                        ],
                    ],
                ],
            ],
        ],
    ],
    'acl' => [
        'guest' => [
        ],
        'member' => [
            'reports' => ['index','create','update','delete', 'view'],
            'reports/config' => ['index', 'create','clear'],
            'reports/default' => ['index','create','update','delete','view'],
        ],
    ],
    'controllers' => [
        'factories' => [
            ConfigController::class => ConfigControllerFactory::class,
            ReportController::class => ReportControllerFactory::class,
        ],
    ],
    'form_elements' => [
        'factories' => [
            ReportForm::class => ReportFormFactory::class,
        ],
    ],
    'navigation' => [
        'default' => [
            [
                'label' => 'Reports',
                'route' => 'reports',
                'class' => 'dropdown',
                'pages' => [
                    [
                        'label' => 'Available Reports',
                        'route' => 'reports',
                    ],
                    [
                        'label' => 'Add New Report',
                        'route' => 'reports/default',
                        'action' => 'create',
                    ],
                    [
                        'label' => 'Settings',
                        'route' => 'reports/config',
                    ],
                ],
            ],
        ],
    ],
    'service_manager' => [
        'aliases' => [
            'report-model-primary-adapter-config' => 'model-primary-adapter-config',
        ],
        'factories' => [
            'report-model-primary-adapter' => ReportModelPrimaryAdapterFactory::class,
        ],
    ],
    'view_manager' => [
        'template_path_stack' => [
            __DIR__ . '/../view',
        ],
    ],
];