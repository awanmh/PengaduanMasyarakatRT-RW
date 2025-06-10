<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Authentication Defaults
    |--------------------------------------------------------------------------
    |
    | This option controls the default authentication "guard" and password
    | reset options for your application. You may change these defaults
    | as required, but they're a perfect start for most applications.
    |
    */

    'defaults' => [
        'guard' => 'web',
        'passwords' => 'users', // Ini juga akan kita ubah
    ],

    /*
    |--------------------------------------------------------------------------
    | Authentication Guards
    |--------------------------------------------------------------------------
    |
    | Next, you may define every authentication guard for your application.
    | Of course, a great default configuration has been defined for you
    | here. You may add or remove these as required in your application.
    |
    | Drivers: "session" for web, "token" for API, "sanctum" for API via tokens.
    |
    */

    'guards' => [
        'web' => [
            'driver' => 'session',
            'provider' => 'users', // Ini menunjuk ke 'providers.users' di bawah
        ],
        'api' => [
            'driver' => 'token', // atau 'sanctum' jika Anda menggunakan Sanctum
            'provider' => 'users',
            'hash' => false,
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | User Providers
    |--------------------------------------------------------------------------
    |
    | All authentication drivers have a user provider. This defines how the
    | users are actually retrieved out of your database or other storage
    | mechanisms to authenticate a user.
    |
    | If you have multiple user tables or models, you may configure multiple
    | sources and pass the provider name to the guard configuration above.
    |
    */

    'providers' => [
        'users' => [
            'driver' => 'eloquent',
            'model' => App\Models\Pengguna::class, // <--- UBAH BARIS INI
        ],

        // 'users' => [
        //     'driver' => 'database',
        //     'table' => 'users',
        // ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Resetting Passwords
    |--------------------------------------------------------------------------
    |
    | You may specify how the password reset functionality of your application
    | works. This gives you the options to set the password broker for resetting
    | passwords. You may also set the name of the table that maintains these
    | reset tokens. We may utilize the database hot to generate these tokens.
    |
    */

    'passwords' => [
        'users' => [ // <--- UBAH BARIS INI
            'provider' => 'users', // Ini menunjuk ke 'providers.users' di atas
            'table' => 'password_reset_tokens', // Sesuaikan jika Anda menggunakan tabel lain untuk reset token
            'expire' => 60,
            'throttle' => 60,
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Password Confirmation Timeout
    |--------------------------------------------------------------------------
    |
    | Here you may define the amount of seconds before a password confirmation
    | times out and the user is prompted to re-enter their password via the
    | confirmation screen. By default, the timeout lasts for three hours.
    |
    */

    'password_timeout' => 10800,

];