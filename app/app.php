<?php
include_once dirname(__FILE__) . '/config.php';

$ping = "pong";

if ( isset( $_GET[ 'a' ] ) ) { $actionA = $_GET[ 'a' ]; } else { $actionA = "main"; }
if ( isset( $_GET[ 'b' ] ) ) { $actionB = $_GET[ 'b' ]; }
if ( isset( $_GET[ 'c' ] ) ) { $actionC = $_GET[ 'c' ]; }

// language
$_SESSION['lang']="tr";

if ( $actionA == "ajax" ) {

	$subActionsAjax = array(
		"public" => array(
			"essaysaver",
			"essayupdater",
			"entrypublisher",
			"entryunpublisher",
			"entryvote",
			"loader",
			"login",
			"logout"
			),
		"admin" => array(
			"lorem",
			"lorem"
			)
		);

	if ( array_key_exists( $actionB, $subActionsAjax ) ) {
		if ($actionB == "admin" && !isAdminLoggedIn()){
			echo getMessage("AdminAuth");
			exit();
		}
		if ( isset( $actionC ) && in_array( $actionC, $subActionsAjax[ $actionB ] ) ) {
			$file = AJAX . "/{$actionB}/{$actionC}.php";
			if (is_file( $file )){
				include_once $file;
				exit();
			} else{ echo getMessage("FileNotFound", $file); exit(); }
		} else{ echo getMessage("404Error"); exit(); }
	} else { echo getMessage("404Error"); exit(); }

	exit();
}

// Admin Panel
/*
if ( $actionA == "administration" ) {
	$subActionsAdmin = array(
		"main"
		);

	if ( !isAdminLoggedIn() ) {
		include_once ACTIONS . "/public/main.php";
		exit();
	}
	if ( !isset( $actionB ) ) {
		include_once ACTIONS . "/admin/main.php";
		exit();
	}
	if ( in_array( $actionB, $subActionsAdmin ) ) {
		$file = ACTIONS . "/admin/{$actionB}.php";
		if (is_file($file)){
			include_once $file;
			exit();
		}
		else{ getMessage("FileNotFound", $file); exit(); }
	} else { getMessage("404Error"); exit(); }
	exit();
}
*/

// Public Site
$actionsPublic = array(
	"main",
	"essay",
	"edit",
	"try",
	"loginoverlay",
	"errorpage",
	"user"
	);

if ( in_array( $actionA, $actionsPublic ) ) {
	include_once ACTIONS . "/public/{$actionA}.php";
	exit();
} 
else {
	include_once ACTIONS . "/public/main.php";
	exit();
}



?>