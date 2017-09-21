<?php

return [
    'groups'     => [
        'basic' => [
            'name' => 'Basic components',
        ],
        'forms' => [
            'name' => 'Forms',
        ],
        'media' => [
            'name' => 'Media',

        ]
    ],
    'components' => [
        'text'    => [
            'name'          => 'Text component',
            'description'   => 'Simple text block',
            'route'         => 'component.text',
            'compatibility' => [

            ],
            'permissions'   => [

            ],
            'group'         => 'basic'
        ],
        'contact' => [
            'name'          => 'Contact form',
            'description'   => 'Simple email contact form',
            'route'         => 'component.text',
            'compatibility' => [

            ],
            'permissions'   => [

            ],
            'group'         => 'forms'
        ],
        'image'   => [
            'name'          => 'Image',
            'description'   => 'Displays an image',
            'route'         => 'component.text',
            'compatibility' => [

            ],
            'permissions'   => [

            ],
            'group'         => 'media'
        ]
    ],
];
