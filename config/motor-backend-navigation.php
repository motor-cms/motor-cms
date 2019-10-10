<?php

return [
    'items' => [
        800 => [
            'slug'        => 'cms',
            'name'        => 'motor-cms::backend/global.cms',
            'icon'        => 'fa fa-home',
            'route'       => null,
            'roles'       => [ 'SuperAdmin' ],
            'permissions' => [ 'cms.read' ],
            'items'       => [
                100 => [ // <-- !!! replace 542 with your own sort position !!!
                    'slug'        => 'navigation_trees',
                    'name'        => 'motor-cms::backend/navigation_trees.navigation_trees',
                    'icon'        => 'fa fa-plus',
                    'route'       => 'backend.navigation_trees.index',
                    'roles'       => [ 'SuperAdmin' ],
                    'permissions' => [ 'navigation_trees.read' ],
                    'aliases'     => [ 'backend.navigations' ]
                ],
                110 => [ // <-- !!! replace 895 with your own sort position !!!
                    'slug' => 'pages',
                    'name'  => 'motor-cms::backend/pages.pages',
                    'icon'  => 'fa fa-plus',
                    'route' => 'backend.pages.index',
                    'roles'       => [ 'SuperAdmin' ],
                    'permissions' => [ 'pages.read' ],
                ],
            ]
        ],
    ]
];
