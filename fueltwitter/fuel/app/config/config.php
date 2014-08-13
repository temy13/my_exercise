<?php
/**
 * Fuel is a fast, lightweight, community driven PHP5 framework.
 *
 * @package    Fuel
 * @version    1.0
 * @author     Fuel Development Team
 * @license    MIT License
 * @copyright  2010 - 2012 Fuel Development Team
 * @link       http://fuelphp.com
 */




return array(
	'always_load' => array(
		'packages' => array(
			'auth',
			),
	),

	/**
 * Localization & internationalization settings
 */
'language'           => 'ja', //'en', // Default language
'language_fallback'  => 'en', // Fallback language when file isn't available for default language

 
'encoding'  => 'UTF-8',
 
/**
 * DateTime settings
 *
 * server_gmt_offset  in seconds the server offset from gmt timestamp when time() is used
 * default_timezone   optional, if you want to change the server's default timezone
 */
'server_gmt_offset'  =>  3600 * 9, //0,
//'default_timezone'   => 'Asia/Tokyo', //'UTC',

'security' => array(
        'uri_filter' => array('htmlentities'),
        'output_filter' => array('Security::htmlentities'),
        'whitelisted_classes' => array(
            'Fuel\\Core\\Response',
            'Fuel\\Core\\View',
            'Fuel\\Core\\ViewModel',
            'Closure'
        	)
    ),
);