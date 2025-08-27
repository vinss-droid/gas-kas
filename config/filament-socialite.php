<?php

return [

    /*
    |--------------------------------------------------------------------------
    | OAuth callback middleware
    |--------------------------------------------------------------------------
    |
    | This option defines the middleware that is applied to the OAuth callback url.
    |
    */

    'middleware' => [
        \Illuminate\Cookie\Middleware\EncryptCookies::class,
        \Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse::class,
        \Illuminate\Session\Middleware\StartSession::class,
        \Illuminate\Session\Middleware\AuthenticateSession::class,
        \Illuminate\View\Middleware\ShareErrorsFromSession::class,
    ],

    'providers' => [
        'google' => [
            'driver' => 'google',
            'label' => 'Login dengan Google',
            'icon' => 'heroicon-o-globe-alt', // opsional
            'color' => 'danger',
        ],
    ],
];
