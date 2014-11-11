<?php

// most recent, most liked etc.
$loadrule = sanitize_string($_POST['loadrule']);
// card display etc.
$displaytype = sanitize_string($_POST['displaytype']);
// essay etc.
$loadtype = sanitize_string($_POST['loadtype']);
// load records between $limitfrom and $loadcount
$limitfrom = sanitize_string($_POST['limitfrom']);
$loadcount = sanitize_string($_POST['loadcount']);
// load specific posts (for ex. load user posts or load general posts)
$loadinfo = sanitize_string($_POST['loadinfo']);
if (isset($_POST['uid'])){ $uid = sanitize_string($_POST['uid']); }

if ($loadinfo=="published"){
	$entries = entry::loadEntries($loadrule, $displaytype, $loadtype, $limitfrom, $loadcount);
	foreach($entries as $e){
		$post = getEntryObject(new entry($e['id']));
		echo $post->cardHtml();
	}
}
else if ($loadinfo=="published_user"){
	$entries = entry::loadUserEntries($uid, $loadrule, $displaytype, $loadtype, $limitfrom, $loadcount, "published");
	foreach($entries as $e){
		$post = getEntryObject(new entry($e['id']));
		echo $post->cardHtml();
	}
}
else if ($loadinfo=="unpublished_user"){
	$entries = entry::loadUserEntries($uid, $loadrule, $displaytype, $loadtype, $limitfrom, $loadcount, "unpublished");
	foreach($entries as $e){
		$post = getEntryObject(new entry($e['id']));
		echo $post->cardHtml();
	}
}