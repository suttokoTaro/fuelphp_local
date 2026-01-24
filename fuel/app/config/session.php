<?php

return array(
    'driver' => 'file',

    'file' => array(
        'path' => APPPATH . 'tmp' . DS . 'sessions',
    ),

    'expire_on_close' => false,
    'expiration_time' => 7200,
);
