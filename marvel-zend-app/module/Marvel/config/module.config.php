<?php
return array(
    'controllers' => array(
        'invokables' => array(
            'Marvel\Controller\Marvel' => 'Marvel\Controller\MarvelController',
        ),
    ),
    
    // The following section is new and should be added to your file
    'router' => array(
        'routes' => array(
            'marvel' => array(
                'type'    => 'segment',
                'options' => array(
                    'route'    => '/marvel[/:action][/:id]',
                    'constraints' => array(
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                    ),
                    'defaults' => array(
                        'controller' => 'Marvel\Controller\Marvel',
                        'action'     => 'index',
                    ),
                ),
            ),
            'paginator' => array(
                'type' => 'segment',
                'options' => array(
                    'route' => '/marvel/comicbycharacter/[:id]/[page/:page]',
                    'defaults' => array(
                        'controller' => 'Marvel\Controller\Marvel',
                        'action'     => 'comicbycharacter',
                        'page' => 1,
                    ),
                ),
            ),
            'paginator_ajax' => array(
                'type' => 'segment',
                'options' => array(
                    'route' => '/marvel/comicbycharacter/ajax/[:id]/[page/:page]',
                    'defaults' => array(
                        'controller' => 'Marvel\Controller\Marvel',
                        'action'     => 'comicbycharacterajax',
                        'page' => 1,
                    ),
                ),
            ),             
        ),
    ),
    
    'view_manager' => array(
        'template_path_stack' => array(
            'marvel' => __DIR__ . '/../view',
        ),
    ),
    
    'view_helpers' => array(
      'invokables' => array(
         'character_alpha_menu' => 'Marvel\View\Helper\CharacterAlphaMenu',
      ),        
    ),
);












?>