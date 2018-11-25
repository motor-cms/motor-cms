<?php

return [
    'groups'     => [
        'basic'      => [
            'name' => 'Basic components',
        ],
        'forms'      => [
            'name' => 'Forms',
        ],
        'media'      => [
            'name' => 'Media',
        ],
        'navigation' => [
            'name' => 'Navigation'
        ]
    ],
    'components' => [
        'navigation-sidebar' => [
            'name'            => 'NavigationSidebar',
            'description'     => 'Show NavigationSidebar component',
            'view'            => 'motor-cms::frontend.components.navigation-sidebar',
            'component_class' => 'Motor\CMS\Components\ComponentNavigationSidebars',
            'compatibility'   => [

            ],
            'permissions'     => [

            ],
            'group'           => 'navigation'
        ],
        'text' => [
            'name'            => 'Text',
            'description'     => 'Show Text component',
            'view'            => 'motor-cms::frontend.components.text',
            'route'           => 'component.texts',
            'component_class' => 'Motor\CMS\Components\ComponentTexts',
            'compatibility'   => [

            ],
            'permissions'     => [

            ],
            'group'           => 'basic'
        ],
    ],
];
