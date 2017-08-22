<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Menus Language Lines
    |--------------------------------------------------------------------------
    |
    | The following language lines are used in menu items throughout the system.
    | Regardless where it is placed, a menu item can be listed here so it is easily
    | found in a intuitive way.
    |
    */

    'backend' => [
        'access' => [
            'title' => 'Access Management',

            'roles' => [
                'all'        => 'All Roles',
                'create'     => 'Create Role',
                'edit'       => 'Edit Role',
                'management' => 'Role Management',
                'main'       => 'Roles',
            ],

            'users' => [
                'all'             => 'All Users',
                'change-password' => 'Change Password',
                'create'          => 'Create User',
                'deactivated'     => 'Deactivated Users',
                'deleted'         => 'Deleted Users',
                'edit'            => 'Edit User',
                'main'            => 'Users',
                'view'            => 'View User',
            ],
        ],

        'heritage' => [
            'title'     => 'Patrimoniu',

            'resources' => [
                'all'             => 'Toate resursele',
                'management'      => 'Management resurse',
                'create'          => 'Adaugă resursă',
                'main'            => 'Resurse',
            ],

            'buildings' => [
                'all'             => 'Toate corpurile',
                'management'      => 'Management corpuri',
                'create'          => 'Adaugă corp',
                'edit'            => 'Editează corp',
                'delete'          => 'Șterge corp',
                'main'            => 'Corpuri',
            ],

            'components' => [
                'all'             => 'Listează elementele',
                'management'      => 'Management elemente',
                'create'          => 'Adaugă element',
                'create_facade'   => 'Adaugă fațadă',
                'edit'            => 'Editează element',
                'main'            => 'Elemente',
                'move_up'         => 'Mută sus',
                'move_down'       => 'Mută jos',
            ],

            'elements' => [
                'remove'          => 'Șterge detaliu',
            ],

            'resource_type_classification' => [
                'management'      => 'Management Tipuri',
            ],

            'actors' => [
                'create'          => 'Create Actor'
            ]

        ],

        'log-viewer' => [
            'main'      => 'Log Viewer',
            'dashboard' => 'Panou de control',
            'logs'      => 'Logs',
        ],

        'sidebar' => [
            'dashboard' => 'Panou de control',
            'heritage'  => 'Patrimoniu',
            'general'   => 'General',
            'system'    => 'Sistem',
        ],
    ],

    'language-picker' => [
        'language' => 'Language',
        /*
         * Add the new language to this array.
         * The key should have the same language code as the folder name.
         * The string should be: 'Language-name-in-your-own-language (Language-name-in-English)'.
         * Be sure to add the new language in alphabetical order.
         */
        'langs' => [
            'ar'    => 'Arabic',
            'zh'    => 'Chinese Simplified',
            'zh-TW' => 'Chinese Traditional',
            'da'    => 'Danish',
            'de'    => 'German',
            'el'    => 'Greek',
            'en'    => 'English',
            'es'    => 'Spanish',
            'fr'    => 'French',
            'id'    => 'Indonesian',
            'it'    => 'Italian',
            'ja'    => 'Japanese',
            'nl'    => 'Dutch',
            'pt_BR' => 'Brazilian Portuguese',
            'ro'    => 'Română',
            'ru'    => 'Russian',
            'sv'    => 'Swedish',
            'th'    => 'Thai',
        ],
    ],
];
