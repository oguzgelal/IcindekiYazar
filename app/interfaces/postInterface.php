<?php
interface postInterface {

	/*************** DB Control ***************/
	public function insert(); // Inserts the class fields to the db
	public function update(); // Updates db with the class fields

	public function isOwner($userid);
	public function getAuthor();
	public function getTime($firstnunit=false);
	public function isPublished();

	/*************** DISPLAYS ***************/
	public function getHtmlContent(); // Print full content - returns html
	public function cardHtml(); // Card display - returns html
	
}