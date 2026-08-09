<?php

// return array(
//     // 'driver' => 'file',

//     // 'file' => array(
//     //     'path' => APPPATH . 'tmp' . DS . 'sessions',
//     // ),
//     'driver' => 'cookie',

//     'expire_on_close' => false,
//     'expiration_time' => 7200,
// );

return array(
    'driver' => 'cookie',

    'encrypt_cookie' => false,

    'cookie' => array(
        'cookie_name' => 'fuelcid',
    ),

    'expire_on_close' => false,
    'expiration_time' => 7200,
);