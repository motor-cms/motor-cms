<?php

return [
    'cms'              => [
        'name'   => 'motor-cms::backend/global.cms',
        'values' => [
            'read'
        ]
    ],
    'navigations'      => [
        'name'   => 'motor-cms::backend/navigations.navigations',
        'values' => [
            'read',
            'write',
            'delete'
        ]
    ],
    'navigation_trees' => [
        'name'   => 'motor-cms::backend/navigation_trees.navigation_trees',
        'values' => [
            'read',
            'write',
            'delete'
        ]
    ],
    'pages'            => [
        'name'   => 'motor-cms::backend/pages.pages',
        'values' => [
            'read',
            'write',
            'delete'
        ]

    ],
];
