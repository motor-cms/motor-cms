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
        'sidebar' => [
            'name'            => 'Sidebar navigation',
            'description'     => 'Show sidebar navigation',
            'view'            => 'motor-cms::frontend.component.navigation.sidebar',
            'component_class' => 'Motor\CMS\Components\Navigation\Sidebar',
            'compatibility'   => [

            ],
            'permissions'     => [

            ],
            'group'           => 'navigation'
        ],
        'text'    => [
            'name'            => 'Text component',
            'description'     => 'Simple text block',
            'route'           => 'component.text',
            'view'            => 'motor-cms::frontend.component.basic.text',
            'component_class' => 'Motor\CMS\Components\Basic\Text',
            'compatibility'   => [

            ],
            'permissions'     => [

            ],
            'group'           => 'basic'
        ],
        'contact' => [
            'name'            => 'Contact form',
            'description'     => 'Simple email contact form',
            'route'           => 'component.text',
            'view'            => 'motor-cms::frontend.component.basic.text',
            'component_class' => 'Motor\CMS\Components\Basic\Text',
            'compatibility'   => [

            ],
            'permissions'     => [

            ],
            'group'           => 'forms'
        ],
        'image'   => [
            'name'            => 'Image',
            'description'     => 'Displays an image',
            'route'           => 'component.text',
            'view'            => 'motor-cms::frontend.component.basic.text',
            'component_class' => 'Motor\CMS\Components\Basic\Text',
            'compatibility'   => [

            ],
            'permissions'     => [

            ],
            'group'           => 'media'
        ]
    ],
];
