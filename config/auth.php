<?php

use App\Models\User;

return [

'guards' => [
    'web' => [
        'driver' => 'session',
        'provider' => 'users',
    ],

    'admin' => [
        'driver' => 'session',
        'provider' => 'administradores',
    ],

    'persona' => [
        'driver' => 'session',
        'provider' => 'personas',
    ],
],

'providers' => [
    'users' => [
        'driver' => 'eloquent',
        'model' => env('AUTH_MODEL', App\Models\User::class),
    ],

    'administradores' => [
        'driver' => 'eloquent',
        'model' => App\Models\Administrador::class,
    ],

    'personas' => [
        'driver' => 'eloquent',
        'model' => App\Models\Persona::class,
    ],
],

'passwords' => [
    'users' => [
        'provider' => 'users',
        'table' => 'password_reset_tokens',
        'expire' => 60,
        'throttle' => 60,
    ],

    'administradores' => [
        'provider' => 'administradores',
        'table' => 'password_reset_tokens',
        'expire' => 15,
        'throttle' => 60,
    ],

    'personas' => [
        'provider' => 'personas',
        'table' => 'password_reset_tokens',
        'expire' => 15,
        'throttle' => 60,
    ],
],

];
