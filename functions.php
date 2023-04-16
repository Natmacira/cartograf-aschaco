<?php

require_once 'env.php';

if (APP_DEBUG_MODE) {
	ini_set('display_errors', 1);
	ini_set('display_startup_errors', 1);
	error_reporting(E_ALL);
} else {
	ini_set('display_errors', 0);
	ini_set('display_startup_errors', 0);
	error_reporting(0);
}

function chaco_set_user_cookie() {
	setcookie( 'userSaved', '1', time() + 60 * 60 * 24 * 30, '/' );
}

function chaco_check_user_cookie() {
	return ! empty( $_COOKIE['userSaved'] );
}

function chaco_sanitize_title( $title ) {
    $title = strtolower($title);
    $title = str_replace(' ', '_', $title);

	// Remove any characters that are not letters, numbers, or underscores
    $title = preg_replace('/[^a-z0-9_]/', '', $title);

    return $title;
}
