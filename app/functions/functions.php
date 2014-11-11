<?php

//function isAdminLoggedIn(){
//}

// creates a new instance of the type of the entry and returns it
function getEntryObject($entry){
	if ($entry->type=="essay"){ return new essay($entry->postid, $entry->posttime); }
	return null;
}

// create and return PDO object
function newPDO(){
	try { $pdo = new PDO("mysql:host=".DB_HOST.";dbname=".DB_NAME.";charset=utf8",DB_USER,DB_PASSWORD,array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'")); } 
	catch (PDOException $e) { echo getMessage("DBConnectionError"); }
	return $pdo;
}

// returns bg image css code
function bgimg($img){
	return "background: url('".$img."'); background-size: cover; background-position: 0 50%;";
}
