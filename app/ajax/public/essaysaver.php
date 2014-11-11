<?php

$essay = new essay();

$htmlcontent = sanitize_string($_POST['htmlcontent']);
$title = sanitize_string($_POST['title']);
$desc = sanitize_string($_POST['desc']);
$image = sanitize_string($_POST['image']);

// TODO : check image essaysaver

$essay->userid = $_SESSION['userid'];
$essay->title = $title;
$essay->desc = $desc;
$essay->image = $image;
$essay->htmlcontent = $htmlcontent;

echo $essay->insert();