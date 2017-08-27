<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | The following language lines contain the default error messages used by
    | the validator class. Some of these rules have multiple versions such
    | as the size rules. Feel free to tweak each of these messages here.
    |
    */

    'accepted'             => 'The :attribute must be accepted.',
    'active_url'           => 'The :attribute is not a valid URL.',
    'after'                => 'The :attribute must be a date after :date.',
    'after_or_equal'       => 'The :attribute must be a date after or equal to :date.',
    'alpha'                => 'The :attribute may only contain letters.',
    'alpha_dash'           => 'The :attribute may only contain letters, numbers, and dashes.',
    'alpha_num'            => 'The :attribute may only contain letters and numbers.',
    'array'                => 'The :attribute must be an array.',
    'before'               => 'The :attribute must be a date before :date.',
    'before_or_equal'      => 'The :attribute must be a date before or equal to :date.',
    'between'              => [
        'numeric' => 'The :attribute must be between :min and :max.',
        'file'    => 'The :attribute must be between :min and :max kilobytes.',
        'string'  => 'The :attribute must be between :min and :max characters.',
        'array'   => 'The :attribute must have between :min and :max items.',
    ],
    'boolean'              => 'The :attribute field must be true or false.',
    'confirmed'            => 'The :attribute confirmation does not match.',
    'date'                 => 'The :attribute is not a valid date.',
    'date_format'          => 'The :attribute does not match the format :format.',
    'different'            => 'The :attribute and :other must be different.',
    'digits'               => 'The :attribute must be :digits digits.',
    'digits_between'       => 'The :attribute must be between :min and :max digits.',
    'dimensions'           => 'The :attribute has invalid image dimensions.',
    'distinct'             => 'The :attribute field has a duplicate value.',
    'email'                => 'The :attribute must be a valid email address.',
    'exists'               => 'The selected :attribute is invalid.',
    'file'                 => 'The :attribute must be a file.',
    'filled'               => 'The :attribute field must have a value.',
    'image'                => 'The :attribute must be an image.',
    'in'                   => 'The selected :attribute is invalid.',
    'in_array'             => 'The :attribute field does not exist in :other.',
    'integer'              => 'The :attribute must be an integer.',
    'ip'                   => 'The :attribute must be a valid IP address.',
    'json'                 => 'The :attribute must be a valid JSON string.',
    'max'                  => [
        'numeric' => 'The :attribute may not be greater than :max.',
        'file'    => 'The :attribute may not be greater than :max kilobytes.',
        'string'  => 'The :attribute may not be greater than :max characters.',
        'array'   => 'The :attribute may not have more than :max items.',
    ],
    'mimes'                => 'The :attribute must be a file of type: :values.',
    'mimetypes'            => 'The :attribute must be a file of type: :values.',
    'min'                  => [
        'numeric' => 'The :attribute must be at least :min.',
        'file'    => 'The :attribute must be at least :min kilobytes.',
        'string'  => 'The :attribute must be at least :min characters.',
        'array'   => 'The :attribute must have at least :min items.',
    ],
    'not_in'               => 'The selected :attribute is invalid.',
    'numeric'              => 'The :attribute must be a number.',
    'present'              => 'The :attribute field must be present.',
    'regex'                => 'The :attribute format is invalid.',
    'required'             => 'The :attribute field is required.',
    'required_if'          => 'The :attribute field is required when :other is :value.',
    'required_unless'      => 'The :attribute field is required unless :other is in :values.',
    'required_with'        => 'The :attribute field is required when :values is present.',
    'required_with_all'    => 'The :attribute field is required when :values is present.',
    'required_without'     => 'The :attribute field is required when :values is not present.',
    'required_without_all' => 'The :attribute field is required when none of :values are present.',
    'same'                 => 'The :attribute and :other must match.',
    'size'                 => [
        'numeric' => 'The :attribute must be :size.',
        'file'    => 'The :attribute must be :size kilobytes.',
        'string'  => 'The :attribute must be :size characters.',
        'array'   => 'The :attribute must contain :size items.',
    ],
    'string'               => 'The :attribute must be a string.',
    'timezone'             => 'The :attribute must be a valid zone.',
    'unique'               => 'The :attribute has already been taken.',
    'uploaded'             => 'The :attribute failed to upload.',
    'url'                  => 'The :attribute format is invalid.',

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | Here you may specify custom validation messages for attributes using the
    | convention "attribute.rule" to name the lines. This makes it quick to
    | specify a specific custom language line for a given attribute rule.
    |
    */

    'custom' => [
        'attribute-name' => [
            'rule-name' => 'custom-message',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Attributes
    |--------------------------------------------------------------------------
    |
    | The following language lines are used to swap attribute place-holders
    | with something more reader friendly such as E-Mail Address instead
    | of "email". This simply helps us make messages a little cleaner.
    |
    */

    'attributes' => [

        'backend' => [
            'access' => [
                'permissions' => [
                    'associated_roles' => 'Associated Roles',
                    'dependencies'     => 'Dependencies',
                    'display_name'     => 'Display Name',
                    'group'            => 'Group',
                    'group_sort'       => 'Group Sort',

                    'groups' => [
                        'name' => 'Group Name',
                    ],

                    'name'   => 'Name',
                    'system' => 'System?',
                ],

                'roles' => [
                    'associated_permissions' => 'Associated Permissions',
                    'name'                   => 'Name',
                    'sort'                   => 'Sort',
                ],

                'users' => [
                    'active'                  => 'Active',
                    'associated_roles'        => 'Associated Roles',
                    'confirmed'               => 'Confirmed',
                    'email'                   => 'E-mail Address',
                    'name'                    => 'Name',
                    'other_permissions'       => 'Other Permissions',
                    'password'                => 'Password',
                    'password_confirmation'   => 'Password Confirmation',
                    'send_confirmation_email' => 'Send Confirmation E-mail',
                ],
            ],

            'heritage' => [
                'resources' => [
                    'current'                  => 'Curent?',
                    'name'                     => 'Name',
                    'date_from'                => 'Date From',
                    'date_to'                  => 'Date To',
                    'building_interval'        => 'Building Interval',
                    'type'                     => 'Resource Type',
                    'levels'                   => 'No. Floors',
                    'description'              => 'Description English',
                    'description_ro'           => 'Description Romanian',
                    'modification_description' => 'Modification description',
                    'notes'                    => 'Notes',
                    'address'                  => 'Address',
                    'district'                 => 'District',
                    'street'                   => 'Street',
                    'number'                   => 'Number',
                    'property_type'            => 'Property Type',
                    'public'                   => 'Public',
                    'private'                  => 'Private',
                    'public_private'           => 'Public/Private',
                    'other'                    => 'Other',
                    'legals'                   => 'Legal Documents',
                    'protection_type'          => 'Protection Type',
                    'protection_code'          => 'Protection Code',
                    'protection_name'          => 'Protection Name',
                    'protection_description'   => 'Protection Description',
                    'heritage_resource_type'   => 'Heritage Resource Type',
                    'architectural_styles'     => 'Architectural Styles',
                    'materials'                => 'Materials',
                    'plot_plan'                => 'Plot plan',
                    'modification_type'        => 'Modification Type',
                    'action_button'            => 'Actions',
                    'add_name_button'          => 'Add Name',
                    'delete_name_button'       => 'Delete Name',
                    'add_type_button'          => 'Add Type',
                    'delete_type_button'       => 'Delete Type',
                    'add_protection_button'    => 'Add Type',
                    'delete_protection_button' => 'Delete Type',
                    'none'                     => 'None',
                    'historical_monument'      => 'Historical Monument',
                    'architectural_ensemble'   => 'Architectural Ensemble',
                    'historical_site'          => 'Historical Site',
                    'protection_area'          => 'Protection Area',
                    'protected_area'           => 'Protected Area',
                    'building_approval'        => 'Building Approval',
                ],
                'buildings' => [
                    'type'                    => 'Building Type',
                    'type_main'               => 'Main',
                    'type_out'                => 'Out',
                    'order'                   => 'Building Order #',
                    'floors'                  => 'Floors',
                    'resource_types'          => 'Heritage Resource Types',
                    'resource_types_single'   => 'Unique Functionality',
                    'resource_types_mixed'    => 'Mixed Functionality',
                    'styles'                  => 'Architectural Styles',
                    'materials'               => 'Materials',
                    'modifications'           => 'Modification Types',
                ],
                'actors' => [
                    'name'                    => 'Name',
                    'appelation'              => 'Appelation',
                    'first_name'              => 'First Name',
                    'last_name'               => 'Last Name',
                    'nick_name'               => 'Nick Name',
                    'keywords'                => 'Keywords',
                    'description'             => 'Description',
                    'legal'                   => 'Judicial?',
                    'date_birth'              => 'Birth Date',
                    'place_birth'             => 'Birth Place',
                    'date_death'              => 'Death Date',
                    'place_death'             => 'Death Place',
                    'relationship'            => 'Relationship',
                ]
            ],
        ],

        'frontend' => [
            'email'                     => 'E-mail Address',
            'name'                      => 'Name',
            'password'                  => 'Password',
            'password_confirmation'     => 'Password Confirmation',
            'old_password'              => 'Old Password',
            'new_password'              => 'New Password',
            'new_password_confirmation' => 'New Password Confirmation',
        ],
    ],

];
