<?php

$entryid = sanitize_string($_POST['entryid']);
$entry = new entry($entryid);

if (!$entry->isOwner($_SESSION['userid'])){
	echo getMessage("NotYourPost");
	exit();
}

echo $entry->unpublish();
