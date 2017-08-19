<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Labels Language Lines
    |--------------------------------------------------------------------------
    |
    | The following language lines are used in labels throughout the system.
    | Regardless where it is placed, a label can be listed here so it is easily
    | found in a intuitive way.
    |
    */

    'general' => [
        'all'     => 'Toate',
        'yes'     => 'Da',
        'no'      => 'Nu',
        'custom'  => 'Personalizează',
        'actions' => 'Acțiuni',
        'active'  => 'Activ',
        'buttons' => [
            'save'   => 'Salvează',
            'update' => 'Actualizează',
        ],
        'hide'              => 'Ascunde',
        'inactive'          => 'Inactiv',
        'none'              => 'Niciunul',
        'show'              => 'Vezi',
        'toggle_navigation' => 'Schimbă navigare',
    ],

    'backend' => [
        'access' => [
            'roles' => [
                'create'     => 'Create Role',
                'edit'       => 'Edit Role',
                'management' => 'Role Management',

                'table' => [
                    'number_of_users' => 'Number of Users',
                    'permissions'     => 'Permissions',
                    'role'            => 'Role',
                    'sort'            => 'Sort',
                    'total'           => 'role total|roles total',
                ],
            ],

            'users' => [
                'active'              => 'Active Users',
                'all_permissions'     => 'All Permissions',
                'change_password'     => 'Change Password',
                'change_password_for' => 'Change Password for :user',
                'create'              => 'Create User',
                'deactivated'         => 'Deactivated Users',
                'deleted'             => 'Deleted Users',
                'edit'                => 'Edit User',
                'management'          => 'User Management',
                'no_permissions'      => 'No Permissions',
                'no_roles'            => 'No Roles to set.',
                'permissions'         => 'Permissions',

                'table' => [
                    'confirmed'      => 'Confirmed',
                    'created'        => 'Created',
                    'email'          => 'E-mail',
                    'id'             => 'ID',
                    'last_updated'   => 'Last Updated',
                    'name'           => 'Name',
                    'no_deactivated' => 'No Deactivated Users',
                    'no_deleted'     => 'No Deleted Users',
                    'roles'          => 'Roles',
                    'total'          => 'user total|users total',
                ],

                'tabs' => [
                    'titles' => [
                        'overview' => 'Overview',
                        'history'  => 'History',
                    ],

                    'content' => [
                        'overview' => [
                            'avatar'       => 'Avatar',
                            'confirmed'    => 'Confirmed',
                            'created_at'   => 'Created At',
                            'deleted_at'   => 'Deleted At',
                            'email'        => 'E-mail',
                            'last_updated' => 'Last Updated',
                            'name'         => 'Name',
                            'status'       => 'Status',
                        ],
                    ],
                ],

                'view' => 'View User',
            ],
        ],
        'heritage' => [
            'resources' => [
                'list'               => 'Listă resurse',
                'create'             => 'Adaugă resurse',
                'edit'               => 'Editează resursă',
                'management'         => 'Management resurse',
                'general'            => 'General',
                'preview'            => 'Previzualizează',
                'location'           => 'Locație',
                'structure'          => 'Structură &amp; Clasificare',
                'components'         => 'Componente',
                'building'           => 'Corp clădire',
                'dimensions'         => 'Dimensiuni',
                'changes'            => 'Schimbări',
                'relations'          => 'Relații',
                'evaluations'        => 'Evaluare',
                'legal'              => 'Legal',
                'buildings_list'     => 'Corpuri',
                'components_list'    => 'Elemente',
                'no_buildings'       => 'Nu există nici un corp de clădire pentru resursa creată',
                'no_components'      => 'Nu există nici un element pentru corpul curent',

                'table' => [
                    'id'                           => 'ID',
                    'name'                         => 'Nume',
                    'address'                      => 'Adresă',
                    'status'                       => 'Status',
                    'progress'                     => 'Progres',
                    'created'                      => 'Creat',
                    'last_updated'                 => 'Actualizat',
                    'confirmed'                    => 'Confirmat',
                ],
            ],
            'building' => [
                'create'             => 'Crează corp clădire',
                'edit'               => 'Editează corp',
                'condition'          => 'Condiție',
                'condition_note'     => 'Condiție / Observații',
                'conditions'         => [
                    'very_good'            => 'Foarte bună (reabilitat)',
                    'good'                 => 'Bună (întreținut/parțial reabilitat)',
                    'fair'                 => 'Medie (conservat)',
                    'poor'                 => 'Proastă (deteriorat/nefolosit)',
                    'very_bad'             => 'Foarte proastă (precolaps/ruină)',
                    'Other'                => 'Altele',
                ]
            ],
            'component' => [
                'pages' => [
                    'list'           => 'Detalii',
                    'changes'        => 'Modificări ale elementului',
                    'observations'   => 'Note',
                    'images'         => 'Imagini descriptive',
                ],
                'roof' => [
                    'chimney_type' => 'Tip coș',
                    'chimney_material' => 'Material coș',
                    'type' => 'Tip acoperiș',
                    'cladding_material' => 'Material finisaj',
                    'details' => 'Detalii acoperiș',
                ],
                'facade' => [
                    'type' => 'Tip fațadă',
                    'cladding_cornice_material' => 'Registrul Cornișei - Finisaj',
                    'cladding_plain_material' => 'Câmp - Finisaj',
                    'cladding_base_material' => 'Soclu - Finisaj',
                    'cornice_details' => 'Registrul Cornișei - Detalii',
                    'plain_details' => 'Câmpul Fațadei - Detalii',
                    'base_details' => 'Soclul - Detalii',
                    'plain_storefront_type' => 'Parter comercial',
                    'plain_window_type' => 'Câmpul Fațadei - Gol',
                    'base_window_type' => 'Soclul - Gol',
                ],
                'access' => [
                    'type' => 'Tip',
                    'door_type' => 'Tip ușă',
                    'entryway_type' => 'Tip acces',
                    'portal_type' => 'Tip portic',
                ],
            ],
            'resource_type_classification' => [
                'list'      => 'Types list',
                'create'     => 'Create type',
                'management' => 'Type Management',

                'table' => [
                    'id'             => 'ID',
                    'type_set'       => 'Set',
                    'type'           => 'Type',
                    'published'      => 'Published',
                    'created'        => 'Created',
                    'updated'        => 'Updated',
                ],
            ]
        ]
    ],

    'frontend' => [

        'auth' => [
            'login_box_title'    => 'Login',
            'login_button'       => 'Login',
            'login_with'         => 'Login with :social_media',
            'register_box_title' => 'Register',
            'register_button'    => 'Register',
            'remember_me'        => 'Remember Me',
        ],

        'passwords' => [
            'forgot_password'                 => 'Forgot Your Password?',
            'reset_password_box_title'        => 'Reset Password',
            'reset_password_button'           => 'Reset Password',
            'send_password_reset_link_button' => 'Send Password Reset Link',
        ],

        'macros' => [
            'country' => [
                'alpha'   => 'Country Alpha Codes',
                'alpha2'  => 'Country Alpha 2 Codes',
                'alpha3'  => 'Country Alpha 3 Codes',
                'numeric' => 'Country Numeric Codes',
            ],

            'macro_examples' => 'Macro Examples',

            'state' => [
                'mexico' => 'Mexico State List',
                'us'     => [
                    'us'       => 'US States',
                    'outlying' => 'US Outlying Territories',
                    'armed'    => 'US Armed Forces',
                ],
            ],

            'territories' => [
                'canada' => 'Canada Province & Territories List',
            ],

            'timezone' => 'Timezone',
        ],

        'user' => [
            'passwords' => [
                'change' => 'Change Password',
            ],

            'profile' => [
                'avatar'             => 'Avatar',
                'created_at'         => 'Created At',
                'edit_information'   => 'Edit Information',
                'email'              => 'E-mail',
                'last_updated'       => 'Last Updated',
                'name'               => 'Name',
                'update_information' => 'Update Information',
            ],
        ],

    ],
];
