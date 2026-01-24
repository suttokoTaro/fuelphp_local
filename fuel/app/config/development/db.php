<?php
/**
 * Fuel is a fast, lightweight, community driven PHP 5.4+ framework.
 *
 * @package    Fuel
 * @version    1.8.2
 * @author     Fuel Development Team
 * @license    MIT License
 * @copyright  2010 - 2019 Fuel Development Team
 * @link       https://fuelphp.com
 */

/**
 * -----------------------------------------------------------------------------
 *  Database settings for development environment
 * -----------------------------------------------------------------------------
 *
 *  These settings get merged with the global settings.
 *
 */

// return array(
// 	'default' => array(
// 		'connection' => array(
// 			'dsn'      => 'mysql:host=localhost;dbname=fuel_dev',
// 			'username' => 'root',
// 			'password' => 'root',
// 		),
// 	),
// );

return [
    'default' => [
        'type'        => 'mysqli',
        'connection'  => [
            'hostname'   => '127.0.0.1',
            'database'   => 'fuel_dev',
            'username'   => 'root',
            'password'   => '',
            'persistent' => false,
        ],
        'charset'   => 'utf8mb4',
        'table_prefix' => '',
    ],
];

