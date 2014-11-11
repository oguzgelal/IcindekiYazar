<?php
	/*
	* E:error #x
	* S:success #x
	* I:info #x
	*/

	function errorPage($message){
		header("Location: /errorpage/".$message);
		exit();
	}

	function readable($message){
		$parts = explode(":", $message);
		if (count($parts) == 1){ return $parts[0]; }
		else{
			if ($parts[0]=="I"){ return $parts[2]; }
			else{ return $parts[1]; }
		}
	}

	// checks if return value is an error string ie. starts with E:
	function isError($message){
		$parts = explode(":", $message);
		if (count($parts) > 1 && $parts[0]=="E"){ return 1; }
		else{ return 0; }
	}

	function getMessage($msgcode, $arg1="", $arg2="", $arg3=""){
		if ($msgcode == "AdminAuth"){ return adminAuth(); }
		else if ($msgcode == "FileNotFound"){ return fileNotFound($arg1); }
		else if ($msgcode == "Error404"){ return error404(); }
		else if ($msgcode == "DBConnectionError"){ return dbConError(); }
		else if ($msgcode == "InDB"){ return inDB($arg1); }
		else if ($msgcode == "PostNotSet"){ return postNotSet(); }
		else if ($msgcode == "EntryPublished"){ return entryPublished(); }
		else if ($msgcode == "EntryNotLoaded"){ return entryNotLoaded(); }
		else if ($msgcode == "TypeNotSet"){ return typeNotSet(); }
		else if ($msgcode == "ContentNotFound"){ return contentNotFound(); }
		else if ($msgcode == "LoadRequestMissingData"){ return loadRequestMissingData($arg1); }
		else if ($msgcode == "EntryNotPublished"){ return entryNotPublished(); }
		else if ($msgcode == "EntrySucPublished"){ return entrySucPublished($arg1); }
		else if ($msgcode == "EssaySaved"){ return essaySaved($arg1); }
		else if ($msgcode == "EssayNotSaved"){ return essayNotSaved($arg1); }
		else if ($msgcode == "EssayUpdated"){ return essayUpdated(); }
		else if ($msgcode == "EssayNotUpdated"){ return essayNotUpdated(); }
		else if ($msgcode == "EntryUnpublished"){ return entryUnpublished(); }
		else if ($msgcode == "EntryNotUnpublished"){ return entryNotUnpublished(); }
		else if ($msgcode == "MissingUserData"){ return missingUserData($arg1); }
		else if ($msgcode == "EmailInUse"){ return emailInUse(); }
		else if ($msgcode == "UserAdded"){ return userAdded($arg1); }
		else if ($msgcode == "UserNotAdded"){ return userNotAdded(); }
		else if ($msgcode == "UserDeleted"){ return userDeleted(); }
		else if ($msgcode == "UserNotDeleted"){ return userNotDeleted(); }
		else if ($msgcode == "UserUpdated"){ return userUpdated(); }
		else if ($msgcode == "UserNotUpdated"){ return userNotUpdated(); }
		else if ($msgcode == "UserLoggedIn"){ return userLoggedIn(); }
		else if ($msgcode == "UserNotLoggedIn"){ return userNotLoggedIn(); }
		else if ($msgcode == "UserLoggedOut"){ return userLoggedOut(); }
		else if ($msgcode == "UserNotLoggedOut"){ return userNotLoggedOut(); }
		else if ($msgcode == "UserMustBeLoggedIn"){ return userMustBeLoggedIn(); }
		else if ($msgcode == "NotYourPost"){ return notYourPost(); }
		else if ($msgcode == "UserNotFound"){ return userNotFound(); }
		else if ($msgcode == "EntryAlreadyPosted"){ return entryAlreadyPosted(); }
		else if ($msgcode == "EntrySucPosted"){ return entrySucPosted($arg1); }
		else if ($msgcode == "EntryNotPosted"){ return entryNotPosted(); }
		else if ($msgcode == "EntryUnposted"){ return entryUnposted(); }
		else if ($msgcode == "EntryNotUnposted"){ return entryNotUnposted(); }
		else if ($msgcode == "UserNotSet"){ return userNotSet(); }
		else if ($msgcode == "CannotVote"){ return cannotVote(); }
		else if ($msgcode == "VotedBefore"){ return votedBefore(); }
		else if ($msgcode == "UnknownError"){ return unknownError(); }
		else if ($msgcode == "InternalServerError"){ return internalServerError(); }
		else if ($msgcode == "Forbidden"){ return forbidden(); }
		
		else { return "E:undefined."; }
	}

	function adminAuth(){ return "E:Erişim yetkiniz yok."; }
	function fileNotFound($file){ return "E:Sorgulanan kaynak bulunamadı : <b>".$file."</b>."; }
	function dbConError(){ return "E:Veritabanına bağlanırken bir hata oluştu."; }
	function error404(){ return "E:Sayfa bulunamadı."; }
	function inDB($id){ return "E:<b>".$id."</b> ID sine sahip entry veritabanında zaten kayıtlı. update() methodunu kullanın."; }
	function postNotSet(){ return "E:Yayımlanacak post belirtilmedi."; }
	function entryPublished(){ return "E:Entry zaten yayında."; }
	function entryNotLoaded(){ return "E:Entry yüklenmeden like eklenemez."; }
	function typeNotSet(){ return "E:Entry türü belirtilmedi."; }
	function contentNotFound(){ return "E:İçerik bulunamadı."; }
	function loadRequestMissingData($missing){ return "E:Data sorgusunda eksik bilgi : <b>".$missing."</b>"; }
	function entryNotPublished(){ return "E:Yayımlanamadı."; }
	function entrySucPublished($id){ return "I:".$id.":Entry Yayımlandı."; }
	function essaySaved($id){ return "I:".$id.":Kaydedildi."; }
	function essayNotSaved(){ return "E:Kaydedilemedi."; }
	function essayUpdated(){ return "S:Kaydedildi."; }
	function essayNotUpdated(){ return "E:Kaydedilemedi."; }
	function entryUnpublished(){ return "S:Entry yayımdan kaldırıldı."; }
	function entryNotUnpublished(){ return "S:Entry yayımdan kaldırılamadı."; }
	function missingUserData($missing){ return "E:Eksik veya hatalı bilgi (".$missing.")."; }
	function emailInUse(){ return "E:E-posta kullanımda."; }
	function userAdded($id){ return "I:".$id.":Kaydedildi."; }
	function userNotAdded(){ return "E:Kullanıcı kaydı yapılırken bir hata oluştu."; }
	function userDeleted(){ return "S:Kullanıcı silindi."; }
	function userNotDeleted(){ return "E:Kullanıcı silinirken bir hata oluştu."; }
	function userUpdated(){ return "S:Kullanıcı bilgileri güncellendi."; }
	function userNotUpdated(){ return "E:Kullanıcı bilgileri güncellenemedi."; }
	function userLoggedIn(){ return "S:Giriş başarılı."; }
	function userNotLoggedIn(){ return "E:Giriş yapılamadı. Lütfen bilgilerinizi kontrol ediniz."; }
	function userLoggedOut(){ return "S:Oturum kapatıldı."; }
	function userNotLoggedOut(){ return "E:Oturum kapatılamadı."; }
	function userMustBeLoggedIn(){ return "E:Bu işlem için giriş yapmalısınız."; }
	function notYourPost(){ return "E:Entry size ait değil. Sadece kendinize ait entryler üzerinde işlem yapabilirsiniz."; }
	function userNotFound(){ return "E:Kullanıcı bulunamadı."; }
	function entryAlreadyPosted(){ return "E:Entry zaten kayıtlı."; }
	function entrySucPosted($id){ return "I:".$id.":Entry kaydedildi."; }
	function entryNotPosted(){ return "E:Entry kaydedilemedi."; }
	function entryUnposted(){ return "S:Kayıt silindi."; }
	function entryNotUnposted(){ return "E:Kayıt silinemedi."; }
	function userNotSet(){ return "E:Kullanıcı belirtilmedi."; }
	function cannotVote(){ return "E:Oy kaydedilemedi."; }
	function votedBefore(){ return "E:Daha önce oy kullandınız."; }
	function unknownError(){ return "E:Bilinmeyen bir hata oluştu."; }
	function internalServerError(){ return "E:Sitemizin sunucularında bir hata meydana geldi. Hatayı en kısa sürede çözmeye çalışıyoruz."; }
	function forbidden(){ return "E:Bu sayfaya erişme yetkiniz yok."; }
	
	?>