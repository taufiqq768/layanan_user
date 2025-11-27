<?php

return [
    'secret' => env('NOCAPTCHA_SECRET'),
    'sitekey' => env('NOCAPTCHA_SITEKEY'),
    'enabled' => env('CAPTCHA_ENABLED', true),
    'options' => [
        'timeout' => 30,
    ],
];
