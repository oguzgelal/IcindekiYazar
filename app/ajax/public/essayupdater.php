<?php

$pid = sanitize_string($_POST['pid']);

$essay = new essay($pid);

if (!$essay->isOwner($_SESSION['userid'])){
	echo getMessage("NotYourPost");
	exit();
}

$htmlcontent = sanitize_string($_POST['htmlcontent']);
$title = sanitize_string($_POST['title']);
$desc = sanitize_string($_POST['desc']);
$image = sanitize_string($_POST['image']);

// TODO : check image essaysaver

$essay->title = $title;
$essay->desc = $desc;
$essay->image = $image;
$essay->htmlcontent = $htmlcontent;

echo $essay->update();
