<?php
// TODO : implement 'remember me'
if (isset($_POST['email']) && isset($_POST['password']) && isset($_POST['rememberme'])){
	$logged = login($_POST['email'] , $_POST['password'], $_POST['rememberme']);
	echo $logged;
}	
else{ 
	echo getMessage("MissingUserData","E-posta/Şifre");
}
?>