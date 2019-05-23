<?php 

use Report\Controller\ReportController;
use Report\Controller\Factory\ReportControllerFactory;
use Report\Form\ReportForm;
use Report\Form\Factory\ReportFormFactory;
use Report\Service\Factory\ReportModelPrimaryAdapterFactory;

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
    'controllers' => [
        'factories' => [
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