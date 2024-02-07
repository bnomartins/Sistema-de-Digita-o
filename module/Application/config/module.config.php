<?php

declare(strict_types=1);

namespace Application;

use Application\Controller\Factory\IndexControllerFactory;
use Application\Controller\Factory\PhraseControllerFactory;
use Application\Controller\Factory\TipyngControllerFactory;
use Application\Controller\Factory\UserControllerFactory;
use Laminas\Router\Http\Literal;
use Laminas\Router\Http\Segment;
use Laminas\ServiceManager\Factory\InvokableFactory;

return [
    'router' => [
        'routes' => [
            'home' => [
                'type'    => Literal::class,
                'options' => [
                    'route'    => '/',
                    'defaults' => [
                        'controller' => Controller\IndexController::class,
                        'action'     => 'index',
                    ],
                ],
            ],
            'adm' => [
                'type'    => Segment::class,
                'options' => [
                    'route'    => '/adm[/:action[/:id]]',
                    'defaults' => [
                        'controller' => Controller\IndexController::class,
                        'action'     => 'index',
                    ],
                    'constraints' => [
                        'actions' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id'      => '[0-9]+'
                    ]
                ],
            ],
            'tipyng' => [
                'type'    => Segment::class,
                'options' => [
                    'route'    => '/tipyng[/:action[/:id]]',
                    'defaults' => [
                        'controller' => Controller\TipyngController::class,
                        'action'     => 'index',
                    ],
                    'constraints' => [
                        'actions' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id'      => '[0-9]+'
                    ]
                ],
            ],            
            'user' => [
                'type'    => Segment::class,
                'options' => [
                    'route'    => '/user[/:action[/:id]]',
                    'defaults' => [
                        'controller' => Controller\UserController::class,
                        'action'     => 'index',
                    ],
                    'constraints' => [
                        'actions' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id'      => '[0-9]+'
                    ]
                ],
            ],      
            'phrase' => [
                'type'    => Segment::class,
                'options' => [
                    'route'    => '/phrase[/:action[/:id]]',
                    'defaults' => [
                        'controller' => Controller\PhraseController::class,
                        'action'     => 'index',
                    ],
                    'constraints' => [
                        'actions' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id'      => '[0-9]+'
                    ]
                ],
            ],      
            'application' => [
                'type'    => Segment::class,
                'options' => [
                    'route'    => '/application[/:action]',
                    'defaults' => [
                        'controller' => Controller\IndexController::class,
                        'action'     => 'index',
                    ],
                ],
            ],

        ],
        
    ],
    'controllers' => [
        'factories' => [
            Controller\IndexController::class => IndexControllerFactory::class,
            Controller\TipyngController::class => TipyngControllerFactory::class,
            Controller\UserController::class => UserControllerFactory::class,
            Controller\PhraseController::class => PhraseControllerFactory::class,
        ],
    ],
    'view_manager' => [
        'display_not_found_reason' => true,
        'display_exceptions'       => true,
        'doctype'                  => 'HTML5',
        'not_found_template'       => 'error/404',
        'exception_template'       => 'error/index',
        'template_map' => [
            'layout/layout'           => __DIR__ . '/../view/layout/layout.phtml',
            'application/index/index' => __DIR__ . '/../view/application/index/index.phtml',
            'error/404'               => __DIR__ . '/../view/error/404.phtml',
            'error/index'             => __DIR__ . '/../view/error/index.phtml',
        ],
        'template_path_stack' => [
            __DIR__ . '/../view',
        ],
    ],
    'doctrine' => [
        'driver' => [
            // defines an annotation driver with two paths, and names it `my_annotation_driver`
            'annotation_driver' => [
                'class' => \Doctrine\ORM\Mapping\Driver\AnnotationDriver::class,
                'cache' => 'array',
                'paths' => [
                    __DIR__.'./../src/Entity'
                ],
            ],

            // default metadata driver, aggregates all other drivers into a single one.
            // Override `orm_default` only if you know what you're doing
            'orm_default' => [
                'drivers' => [
                    // register `my_annotation_driver` for any entity under namespace `My\Namespace`
                    'Application\Entity' => 'annotation_driver',
                ],
            ],
            'candidate' =>[
                'class' => MappingDriverChain::class,
                'drivers' => [
                    'class' => AnnotationDriver::class,
                    'cache' => 'array',
                    'paths' => __DIR__ . '/../src/Entity/Candidate'
                ]
            ]            
        ],
    ],

];
