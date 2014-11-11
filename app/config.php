<?php

session_name( 'icindekiyazar' );
if(session_id() == '') {
    session_start();
}

define( "DB_NAME", "icindekiyazar" );
define( "DB_USER", "root" );
define( "DB_PASSWORD", "root" );
define( "DB_HOST", "localhost" );


define( "TABLE_ENTRY", "entry" );
define( "TABLE_POST", "post" );
define( "TABLE_USER", "users" );
define( "TABLE_USERLIKE", "userlike" );
define( "TABLE_ESSAY", "essay" );
define( "TABLE_ESSAY_DATA", "essay_data" );

define( "ROOT", dirname(__FILE__) );
define( "ACTIONS", ROOT . "/actions" );
define( "AJAX", ROOT . "/ajax" );
//define( "HEADERIMG", ROOT . "/img/DefaultHeader" );
define( "HEADERIMG", "/app/img/DefaultHeader" );

define ( "USER", "1" );
define ( "ADMIN", "2" );

define( "COOKIE_EXPIRE" , 2592000 );


// Load required php functions
$functions = glob( ROOT . "/functions/*.php" );
if ( $functions && is_array( $functions ) ) {
	foreach ( $functions as $file ) {
		include_once $file;
	}
} unset( $functions );

// Load required php interfaces
$interfaces = glob( ROOT . "/interfaces/*.php" );
if ( $interfaces && is_array( $interfaces ) ) {
	foreach ( $interfaces as $file ) {
		include_once $file;
	}
} unset( $interfaces );

// Load required php classes
$classes = glob( ROOT . "/classes/*.php" );
if ( $classes && is_array( $classes ) ) {
	foreach ( $classes as $file ) {
		include_once $file;
	}
} unset( $classes );
