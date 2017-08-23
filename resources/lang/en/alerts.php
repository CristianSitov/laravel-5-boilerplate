<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Alert Language Lines
    |--------------------------------------------------------------------------
    |
    | The following language lines contain alert messages for various scenarios
    | during CRUD operations. You are free to modify these language lines
    | according to your application's requirements.
    |
    */

    'backend' => [
        'roles' => [
            'created' => 'The role was successfully created.',
            'deleted' => 'The role was successfully deleted.',
            'updated' => 'The role was successfully updated.',
        ],

        'users' => [
            'confirmation_email'  => 'A new confirmation e-mail has been sent to the address on file.',
            'created'             => 'The user was successfully created.',
            'deleted'             => 'The user was successfully deleted.',
            'deleted_permanently' => 'The user was deleted permanently.',
            'restored'            => 'The user was successfully restored.',
            'session_cleared'      => "The user's session was successfully cleared.",
            'updated'             => 'The user was successfully updated.',
            'updated_password'    => "The user's password was successfully updated.",
        ],

        'resources' => [
            'created' => 'The Heritage Resource was successfully created.',
            'deleted' => 'The Heritage Resource was successfully deleted.'
        ],

        'components' => [
            'updated' => 'The Components were successfully updated.',
            'deleted' => 'The Components were successfully deleted.'
        ],

        'elements' => [
            'deleted' => 'The Architectural Elements were successfully deleted.'
        ],

        'actors' => [
            'created' => 'The Actor was successfully created.',
            'updated' => 'The Actor was successfully updated.',
            'detached' => 'The Actor was successfully detached.',
        ],
    ],
];
