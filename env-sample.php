<?php

/**
 * Note: This file is not used by the application. It is only here for reference.
 * 		 You should copy this file to env.php and change the values to your own.
 */

// select your type of environment
define('APP_ENV', 'development'); // development || staging || production

if (APP_ENV === 'production' || APP_ENV === 'staging') {
    define('APP_DB_USER', '');
    define('APP_DB_PASSWORD', '');
    define('APP_DB_HOST', '');
    define('APP_DB_NAME', '');
} else {
    define('APP_DB_USER', '');
    define('APP_DB_PASSWORD', '');
    define('APP_DB_HOST', '');
    define('APP_DB_NAME', '');
}

if (APP_ENV === 'production') {
    define('APP_HOME_URL', 'https://cartografiaschaco.com/');
} elseif (APP_ENV === 'staging') {
    define('APP_HOME_URL', 'https://cartografiaschaco.altcooperativa.com/');
} else {
    define('APP_HOME_URL', 'https://localhost/cartografiaschaco/');
}

define('APP_DEBUG_MODE', true);
