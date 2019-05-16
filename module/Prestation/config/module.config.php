<?php

namespace Prestation;

return array(
    'router' => array(
        'routes' => array(
/*            'home' => array(
                'type' => 'Zend\Mvc\Router\Http\Literal',
                'options' => array(
                    'route'    => '/zf/',
                    'defaults' => array(
                        'controller' => 'Application\Controller\Index',
                        'action'     => 'index',
                    ),
                ),
            ),*/
            // The following is a route to simplify getting started creating
            // new controllers and actions without needing to create a new
            // module. Simply drop new controllers in, and you can access them
            // using the path /zf/:controller/:action
            /*
             *             'backup-prestation' => array(
                'type'    => 'Segment',
                'options' => array(
                    'route'    => '/admin/api[/:slug]',
                    'constraints' => array(
                        'slug' => '[a-zA-Z][a-zA-Z0-9_-]*',
                    ),
                    'defaults' => array(
                        '__NAMESPACE__' => 'Admin\Controller',
                        'controller'    => 'AdminRest'
                    ),
                ),

            ),
             */
/*            'api' => array(
                'type'    => 'Literal',
                'options' => array(
                    'route'    => '/api',
                    'defaults' => array(
                        '__NAMESPACE__' => 'Prestation\Controller',
                        'controller'    => 'Prestation',

                    ),
                ),
            ),*/
            'api' => array(
                'type'    => 'Literal',
                'options' => array(
                    'route'    => '/api',
                    'defaults' => array(
                        '__NAMESPACE__' => 'Prestation\Controller',
                        'controller'    => 'Prestation'
                        /*                        '__NAMESPACE__' => 'Admin\Controller',
                                                'controller'    => 'Index',
                                                'action'        => 'index',
                                                'page'          => 1,*/
                    ),
                ),
                'may_terminate' => true,
                'child_routes' => array(
                    'default' => array(
                        'type'    => 'Segment',
                        'options' => array(
                            'route'    => '/[:controller[/:slug]]',
                            'constraints' => array(
                                'controller' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'slug' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                //'req'     => '[a-zA-Z][a-zA-Z0-9_-]*',
                            ),
                            'defaults' => array(
/*                                '__NAMESPACE__' => 'Prestation\Controller',
                                'controller'    => 'Prestation'*/
                            ),
                        ),
                    ),
                )
            ),
/*            'api' => array(
                'type'    => 'Literal',
                'options' => array(
                    'route'    => '/ap',
                    'defaults' => array(
                        '__NAMESPACE__' => 'Prestation\Controller',
                        'controller'    => 'Index',
                        'action'        => 'index',
                    ),
                ),
                'may_terminate' => true,
                'child_routes' => array(
                    'default' => array(
                        'type'    => 'Segment',
                        'options' => array(
                            'route'    => '/[:controller[/:action]]',
                            'constraints' => array(
                                'controller' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'action'     => '[a-zA-Z][a-zA-Z0-9_-]*',
                            ),
                            'defaults' => array(
                            ),
                        ),
                    ),
                ),
            ),*/

        ),
    ),
    'controllers' => array(
        'invokables' => array(
            'Prestation\Controller\Index' => Controller\IndexController::class,
            'Prestation\Controller\Prestation' => Controller\PrestationRestController::class

        ),
    ),

    'view_manager' => array(
        'strategies' => array(
            'ViewJsonStrategy',
        ),
        'template_path_stack' => array(
            __DIR__ . '/../view',
        ),
    ),
);