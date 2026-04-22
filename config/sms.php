<?php

return [
    // Active provider: 'lsim' or 'postaGuvercini'
    'PROVIDER' => env('SMS_PROVIDER', 'lsim'),

    // L.Sim
    'API_URL'      => env('LSIM_API_URL', 'https://apps.lsim.az/quicksms/v1/send'),
    'API_KEY'      => env('LSIM_API_KEY', 'x%zflgl2wKcQ'),
    'API_USERNAME' => env('LSIM_API_USERNAME', 'embaFotp'),
    'SENDER'       => env('LSIM_SENDER', 'Embafinans'),

    // Posta Güvercini
    'PG_API_URL'    => env('PG_API_URL', ''),
    'PG_PUBLIC_KEY' => env('PG_PUBLIC_KEY', ''),
    'PG_PRIVATE_KEY'=> env('PG_PRIVATE_KEY', ''),
    'PG_SENDER'     => env('PG_SENDER', 'Embafinans'),
];
