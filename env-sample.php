<?php

/**
 * Note: This file is not used by the application. It is only here for reference.
 * 		 You should copy this file to env.php and change the values to your own.
 */

// select your type of environment
putenv( 'ENV=staging' ); // development || staging || production

if ( getenv( 'ENV' ) === 'production' || getenv( 'ENV' ) === 'staging' ) {
	// your credentaials for production or staging
	putenv( 'DB_USER=user' );
	putenv( 'DB_PASSWORD=pass' );
	putenv( 'DB_HOST=localhost' );
	putenv( 'DB_NAME=dbname' );
} else {
	// your credentials for development
	putenv( 'DB_USER=user' );
	putenv( 'DB_PASSWORD=pass' );
	putenv( 'DB_HOST=localhost' );
	putenv( 'DB_NAME=dbname' );
}

if ( getenv( 'ENV' ) === 'production' ) {
	putenv( 'HOME_URL=https://cartografiaschaco.com/' );
} elseif ( getenv( 'ENV' ) === 'staging' ) {
	putenv( 'HOME_URL=https://cartografiaschaco.altcooperativa.com/' );
} else {
	putenv( 'HOME_URL=https://localhost/cartografiaschaco/' );
}