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
        'all'     => 'All',
        'yes'     => 'Yes',
        'no'      => 'No',
        'custom'  => 'Custom',
        'actions' => 'Actions',
        'active'  => 'Active',
        'buttons' => [
            'save'   => 'Save',
            'update' => 'Update',
        ],
        'hide'              => 'Hide',
        'inactive'          => 'Inactive',
        'none'              => 'None',
        'show'              => 'Show',
        'toggle_navigation' => 'Toggle Navigation',
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
                'list'               => 'Resources list',
                'create'             => 'Create Resource',
                'edit'               => 'Edit Resource',
                'management'         => 'Resource Management',
                'general'            => 'General',
                'preview'            => 'Preview',
                'location'           => 'Location',
                'structure'          => 'Structure &amp; Classification',
                'components'         => 'Components',
                'building'           => 'Building',
                'dimensions'         => 'Dimensions',
                'changes'            => 'Changes',
                'relations'          => 'Relations',
                'evaluations'        => 'Evaluations',
                'legal'              => 'Legal',
                'buildings_list'     => 'Buildings List',
                'components_list'    => 'Components List',
                'no_buildings'       => 'No Buildings for current Heritage Resource',
                'no_components'      => 'No Components for current Building',

                'table' => [
                    'id'                           => 'ID',
                    'name'                         => 'Name',
                    'address'                      => 'Address',
                    'status'                       => 'Status',
                    'progress'                     => 'Progress',
                    'created'                      => 'Created',
                    'last_updated'                 => 'Last Updated',
                    'confirmed'                    => 'Confirmed',
                ],
            ],
            'building' => [
                'create'             => 'Create building',
                'edit'               => 'Edit building',
                'condition'          => 'Condition',
                'condition_note'     => 'Condition Note',
                'conditions'         => [
                    'very_good'            => 'Very good',
                    'good'                 => 'Good',
                    'fair'                 => 'Fair',
                    'poor'                 => 'Poor',
                    'very_bad'             => 'Very bad',
                ]
            ],
            'component' => [
                'pages' => [
                    'list'           => 'Elements & Details List',
                    'changes'        => 'Modifications on component',
                    'observations'   => 'Notes',
                    'images'         => 'Descriptive images',
                ],
                'roof' => [
                    'chimney_type' => 'Chimney Type',
                    'chimney_material' => 'Chimney Material',
                    'type' => 'Roof Type',
                    'cladding_material' => 'Cladding Material',
                    'details' => 'Roof Details',
                ],
                'facade' => [
                    'type' => 'Facade Type',
                    'cladding_cornice_material' => 'Cladding Cornice Material',
                    'cladding_plain_material' => 'Cladding Plain Material',
                    'cladding_base_material' => 'Cladding Base Material',
                    'cornice_details' => 'Cornice Details',
                    'plain_details' => 'Plain Details',
                    'base_details' => 'Base Details',
                    'plain_storefront_type' => 'Storefront Type',
                    'plain_window_type' => 'Plain Window Type',
                    'base_window_type' => 'Base Window Type',
                ],
                'access' => [
                    'door_type' => 'Door Type',
                    'entryway_type' => 'Entryway Type',
                    'portal_type' => 'Portal Type',
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
