<?php

class essay implements postInterface {

	public $type = "essay";

	public $id = -1;
	public $found = -1;
	public $dataid = -1;
	public $userid = -1;
	public $htmlcontent;
	public $title;
	public $desc;
	public $image;

	public $posttime;

	public function essay($id=false, $posttime=false){
		if ($id){ $this->Load($id,$posttime); }
	}
	public function Load($id, $posttime){
		$this->posttime = $posttime;
		$this->id = $id;
		$pdo = newPDO();
		$query = $pdo->prepare("SELECT * FROM ".TABLE_ESSAY." WHERE id=:id LIMIT 1");
		$query->execute(array(':id'=>$this->id));
		$results = $query->fetchAll(PDO::FETCH_ASSOC);
		if (count($results) > 0) {
			$this->found = 1;
			foreach($results as $r){
				$this->userid = $r['userid'];
				$this->dataid = $r['dataid'];
				$this->title = $r['title'];
				$this->desc = $r['desc'];
				$this->image = $r['image'];
			}
		}
		else{ $found = 0; }
	}

	public function insert(){
		if ($this->id != -1){ return getMessage("InDB", $this->id); }
		else{
			$pdo = newPDO();
			$query = $pdo->prepare("INSERT INTO ".TABLE_ESSAY_DATA." VALUES (:id, :data)");
			$res1 = $query->execute(array(':id'=>'', ':data'=>$this->htmlcontent));
			$this->dataid = $pdo->lastInsertId();
			
			$query = $pdo->prepare("INSERT INTO ".TABLE_ESSAY." VALUES (
				:id,
				:userid,
				:dataid,
				:title,
				:desc,
				:image
				)");

			$res2 = $query->execute(array(
				':id'=>'',
				':userid'=>$this->userid,
				':dataid'=>$this->dataid,
				':title'=>$this->title,
				':desc'=>$this->desc,
				':image'=>$this->image
				));

			if ($res1 && $res2){
				$this->id = $pdo->lastInsertId();

				$entry = new entry();
				$entry->postid = $this->id;
				$entry->userid = $this->userid;
				$entry->type = $this->type;
				$entry->like = 0;
				$entry->dislike = 0;
				$entry->published = 0;
				$res3 = $entry->save();

				if ($res3){ return getMessage("EssaySaved", $this->id); }
				else{ return getMessage("EssayNotSaved"); }

			}
			else{ return getMessage("EssayNotSaved"); }
		}
	}

	public function update(){
		$pdo = newPDO();
		/*update basic info*/
		$query = $pdo->prepare("UPDATE ".TABLE_ESSAY." SET 
			`userid` = :userid, 
			`dataid` = :dataid, 
			`title` = :title, 
			`desc` = :desc,
			`image` = :image 
			WHERE `id` = ".$this->id);

		$q1 = $query->execute(array(
			':userid'=>$this->userid, 
			':dataid'=>$this->dataid, 
			':title'=>$this->title, 
			':desc'=>$this->desc,
			':image'=>$this->image
			));
		/*update data*/
		$query = $pdo->prepare("UPDATE ".TABLE_ESSAY_DATA." SET `data` = :data WHERE `id` = ".$this->dataid);
		$q2 = $query->execute(array( ':data'=>$this->htmlcontent ));

		if ($q1 && $q2){ return getMessage("EssayUpdated"); }
		else { return getMessage("EssayNotUpdated"); }
	}

	public function isOwner($userid){
		return $userid==$this->userid;
	}

	public function getAuthor(){
		return user::getName($this->userid);
	}
	public function getTime($firstnunit=false){
		if (!$firstnunit){ $firstnunit=999; }
		return secsToTime(time()-$this->posttime, $firstnunit);
	}

	public function getLikesDislikes(){
		return entry::getLikesDislikesByPid($this->id, "essay");
	}

	public function isPublished(){
		$pdo = newPDO();
		$query = $pdo->prepare("SELECT published FROM ".TABLE_ENTRY." WHERE postid=:id AND type=:type LIMIT 1");
		$query->execute(array(':id'=>$this->id, ':type'=>$this->type));
		$results = $query->fetchAll(PDO::FETCH_ASSOC);
		if (count($results) > 0){
			return $results[0]['published'];
		}
		else{
			return -1;
		}
	}

	

	/* DISPLAY HTMLs */

	public function getHtmlContent(){
		if ($this->id==-1 || $this->dataid==-1){ return getMessage("ContentNotFound"); }
		else{
			$pdo = newPDO();
			$query = $pdo->prepare("SELECT * FROM ".TABLE_ESSAY_DATA." WHERE id=:id LIMIT 1");
			$query->execute(array(':id'=>$this->dataid));
			$results = $query->fetchAll(PDO::FETCH_ASSOC);
			if (count($results) > 0) {
				foreach($results as $r){ $this->htmlcontent = $r['data']; }
				return $this->htmlcontent;
			}
			else{ return getMessage("ContentNotFound"); }
		}
	}

	public function cardHtml(){
		$likesdislikes = $this->getLikesDislikes();
		$cardhtml = "
		<div class='postblock' id='".$this->id."' type='essay'>
		<div class='postblockcont'>
		<a href='/essay/".$this->id."'>
		<div class='visual' style='background: url(\"".$this->image."\"); background-size: cover; background-position: 0 50%;'></div>
		</a>
		<div class='postdata'>
		<div class='title'><a href='/essay/".$this->id."'>".$this->title."</a></div>
		<div class='shortdesc'><a href='/essay/".$this->id."'>".$this->desc."</a></div>
		<div class='author'><a href='/user/".$this->userid."'>".$this->getAuthor()."</a></div>";
		if ($this->posttime != ""){
			$cardhtml .= "<div class='posttime' data-toggle='tooltip' title='Eklenme zamanı - ".simpleDate($this->posttime)."'>".$this->getTime(1)."</div>";
		}
		$cardhtml .= "<div class='posttime'>
		<span class='glyphicon glyphicon-thumbs-up' style='margin-right:2px;'></span>".$likesdislikes[0]."
		</div>
		</div>
		</div>
		</div>
		";
		return $cardhtml;
	}
}