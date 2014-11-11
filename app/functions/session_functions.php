<?php
function login($email, $password, $rememberme){
	$pdo = newPDO();
	$email = sanitize_string($email);
	$password = sanitize_string($password);
	$query = $pdo->prepare("SELECT id FROM ".TABLE_USER." WHERE email=:email AND password=:password LIMIT 1");
	$query->execute(array(':email'=>$email, ':password'=>$password));
	$result = $query->fetch(PDO::FETCH_ASSOC);
	if (count($result['id']) == 1){ 
		startSession($result['id']);
		if ($rememberme == "true"){ sendCookie($result['id']); }
		return getMessage("UserLoggedIn");
	}
	else{ return getMessage("UserNotLoggedIn"); }
}
function logout(){
	$userid_logout = $_SESSION['userid'];
	$_SESSION['logged_in'] = 0;
	$_SESSION['userid'] = 0;
	unset($_SESSION['logged_in']);
	unset($_SESSION['userid']);
	session_destroy();
	deleteCookie($userid_logout);
	if (!isLoggedIn()){ return getMessage("UserLoggedOut"); }
	else { return getMessage("UserNotLoggedOut");	}
}
function sendCookie($userid_sc){
	setcookie("rememberme", $userid_sc, time()+COOKIE_EXPIRE);
}
function deleteCookie($userid_dc){
	unset($_COOKIE['rememberme']);
	setcookie("rememberme", $userid_dc, time()-COOKIE_EXPIRE);
}
function cookieLogin(){
	if (!isLoggedIn()){
		if (isset($_COOKIE['rememberme'])){
			$userid_cl = $_COOKIE['rememberme'];
			startSession($userid_cl);
		}
	}
}
function startSession($id){
	$_SESSION['logged_in'] = 1;
	$_SESSION['userid'] = $id;
}
function isLoggedIn(){ 
	return isset($_SESSION['userid']);
}
function isAdminLoggedIn(){ 
	if (isLoggedIn()){
		$loggedid = $_SESSION['userid'];
		$pdo = newPDO();
		$query = $pdo->prepare("SELECT type FROM ".TABLE_USER." WHERE id=:id LIMIT 1");
		$query->execute(array(':id'=>$loggedid));
		$result = $query->fetch(PDO::FETCH_ASSOC);
		return ($result['type'] == ADMIN);
	}
	else{ return false;	}
}