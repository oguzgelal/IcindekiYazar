<?php
class entry {
	
	public $entryid = -1;
	public $found;

	public $postid = -1; //* required for publish
	public $userid = -1; //* required for publish
	public $posttime; //* required for publish
	public $type = ""; //* required for publish
	public $like = 0;
	public $dislike = 0;
	public $published = -1;

	public function entry($entryid = false){
		if($entryid){ $this->Load($entryid); }
	}

	public static function loadEntries($loadrule, $displaytype, $loadtype, $limitfrom, $loadcount){

		if ($loadrule==""){ echo getMessage("LoadRequestMissingData", "Load Rule"); exit(); }
		if ($displaytype==""){ echo getMessage("LoadRequestMissingData", "Display Type"); exit(); }
		if ($loadtype==""){ echo getMessage("LoadRequestMissingData", "Load Type"); exit(); }
		if ($limitfrom==""){ echo getMessage("LoadRequestMissingData", "Limit From"); exit(); }
		if ($loadcount==""){ echo getMessage("LoadRequestMissingData", "Load Count"); exit(); }

		$sql = "SELECT * FROM ".TABLE_ENTRY." WHERE published='1'";
		if ($loadtype != "any"){ $sql .= " AND type='".$loadtype."'"; }
		if ($loadrule=="latest"){ $sql.=" ORDER BY posttime DESC"; }
		$sql.=" LIMIT ".$limitfrom.",".$loadcount;

		$pdo = newPDO();
		$query = $pdo->prepare($sql);
		$query->execute();
		return $query->fetchAll(PDO::FETCH_ASSOC);
	}

	public static function loadUserEntries($uid, $loadrule, $displaytype, $loadtype, $limitfrom, $loadcount, $published=false){

		if ($uid==""){ echo getMessage("LoadRequestMissingData", "User ID"); exit(); }
		if ($loadrule==""){ echo getMessage("LoadRequestMissingData", "Load Rule"); exit(); }
		if ($displaytype==""){ echo getMessage("LoadRequestMissingData", "Display Type"); exit(); }
		if ($loadtype==""){ echo getMessage("LoadRequestMissingData", "Load Type"); exit(); }
		if ($limitfrom==""){ echo getMessage("LoadRequestMissingData", "Limit From"); exit(); }
		if ($loadcount==""){ echo getMessage("LoadRequestMissingData", "Load Count"); exit(); }

		
		$sql = "SELECT * FROM ".TABLE_ENTRY." WHERE userid=".$uid;
		if ($published && $published=="published"){ $sql .= " AND published='1'"; }
		else if ($published && $published=="unpublished"){ $sql .= " AND published='0'"; }
		if ($loadtype != "any"){ $sql .= " AND type='".$loadtype."'"; }
		if ($loadrule=="latest"){ $sql.=" ORDER BY posttime DESC"; }
		$sql.=" LIMIT ".$limitfrom.",".$loadcount;

		$pdo = newPDO();
		$query = $pdo->prepare($sql);
		$query->execute();
		return $query->fetchAll(PDO::FETCH_ASSOC);
	}

	public static function getLikesDislikesByPid($postid, $type){
		$pdo = newPDO();
		$query = $pdo->prepare("SELECT tot_like, tot_dislike FROM ".TABLE_ENTRY." WHERE postid=:postid AND type=:type LIMIT 1");
		$query->execute(array(':postid'=>$postid, ':type'=>$type));
		$results = $query->fetchAll(PDO::FETCH_ASSOC);
		$res = array($results[0]['tot_like'], $results[0]['tot_dislike']);
		return $res;
	}

	public function Load($entryid){
		$this->entryid = $entryid;
		$pdo = newPDO();
		$query = $pdo->prepare("SELECT * FROM ".TABLE_ENTRY." WHERE id=:id LIMIT 1");
		$query->execute(array(':id'=>$this->entryid));
		$results = $query->fetchAll(PDO::FETCH_ASSOC);
		if (count($results) > 0) {
			$this->found = 1;
			foreach($results as $r){
				$this->postid = $r['postid'];
				$this->posttime = $r['posttime'];
				$this->userid = $r['userid'];
				$this->type = $r['type'];
				$this->like = $r['tot_like'];
				$this->dislike = $r['tot_dislike'];
				$this->published = $r['published'];
			}
		}
		else{ $found = 0; }
	}

	public function LoadByPid($postid, $type){
		$this->postid = $postid;
		$this->type = $type;
		$pdo = newPDO();
		$query = $pdo->prepare("SELECT * FROM ".TABLE_ENTRY." WHERE postid=:postid AND type=:type LIMIT 1");
		$query->execute(array(':postid'=>$this->postid, ':type'=>$this->type));
		$results = $query->fetchAll(PDO::FETCH_ASSOC);
		if (count($results) > 0) {
			$this->found = 1;
			foreach($results as $r){
				$this->entryid = $r['id'];
				$this->postid = $r['postid'];
				$this->posttime = $r['posttime'];
				$this->userid = $r['userid'];
				$this->type = $r['type'];
				$this->like = $r['tot_like'];
				$this->dislike = $r['tot_dislike'];
				$this->published = $r['published'];
			}
		}
		else{ $found = 0; }
	}

	public function isOwner($userid){
		return $userid==$this->userid;
	}

	public function postExists(){
		$pdo = newPDO();
		$query = $pdo->prepare("SELECT * FROM ".TABLE_ENTRY." WHERE postid=:id AND type=:type LIMIT 1");
		$query->execute(array(':id'=>$this->postid, ':type'=>$this->type));
		$results = $query->fetchAll(PDO::FETCH_ASSOC);
		if (count($results) > 0) { return 1; }
		else{ return 0; }
	}

	public function save(){
		if ($this->postid == -1){ return getMessage("PostNotSet"); }
		else if ($this->entryid != -1){ return getMessage("EntryPublished"); }
		else if ($this->type == ""){ return getMessage("TypeNotSet"); }
		else if ($this->postExists() == 1){ return getMessage("EntryPublished"); }
		else{
			$this->like = 0;
			$this->dislike = 0;
			$this->published = 0;
			$this->posttime = time();
			$pdo = newPDO();
			$query = $pdo->prepare("INSERT INTO ".TABLE_ENTRY." VALUES (
				:id,
				:postid,
				:userid,
				:posttime,
				:type,
				:tot_like,
				:tot_dislike,
				:published
				)");

			$res = $query->execute(array(
				':id'=>'',
				':postid'=>$this->postid,
				':userid'=>$this->userid,
				':posttime'=>$this->posttime,
				':type'=>$this->type,
				':tot_like'=>$this->like,
				':tot_dislike'=>$this->dislike,
				':published'=>$this->published
				));
			return $res;
			//if ($res){ return getMessage("EntrySucPosted", $pdo->lastInsertId()); }
			//else { return getMessage("EntryNotPosted"); }
		}
	}

	public function publish(){
		if ($this->entryid == -1){ return getMessage("PostNotSet"); }
		else{
			$this->posttime = time();
			$pdo = newPDO();
			$query = $pdo->prepare("UPDATE ".TABLE_ENTRY." SET `published` = '1' WHERE `id` = ".$this->entryid);
			$this->published=1;
			$res1 = $query->execute();
			$query = $pdo->prepare("UPDATE ".TABLE_ENTRY." SET `posttime` = ".$this->posttime." WHERE `id` = ".$this->entryid);
			$res2 = $query->execute();

			if ($res1 && $res2){ return getMessage("EntrySucPublished", $this->entryid); }
			else { return getMessage("EntryNotPublished"); }
		}
	}

	public function unpublish(){
		if ($this->entryid == -1){ return getMessage("PostNotSet"); }
		else{
			$pdo = newPDO();
			$query = $pdo->prepare("UPDATE ".TABLE_ENTRY." SET `published` = '0' WHERE `id` = ".$this->entryid);
			$this->published=0;
			$res = $query->execute();
			if ($res){ return getMessage("EntryUnpublished"); }
			else { return getMessage("EntryNotUnpublished"); }
		}
	}

	// if logged user didn't vote before returns 0. else, if the vote is a like returns 1 else returns -1
	public function userVoted(){
		if (isset($_SESSION['userid'])){
			$pdo = newPDO();
			$query = $pdo->prepare("SELECT * FROM ".TABLE_USERLIKE." WHERE userid=:uid AND entryid=:entryid LIMIT 1");
			$query->execute(array(':uid'=>$_SESSION['userid'], ':entryid'=>$this->entryid));
			$results = $query->fetchAll(PDO::FETCH_ASSOC);
			if (count($results) > 0) { return $results[0]['vote']; }
			else{ return "0"; }
		}
		return null;
	}

	public function addLike(){
		if ($this->like==-1 || $this->entryid==-1){ return getMessage("EntryNotLoaded"); }
		else{
			$pdo = newPDO();
			// check if voted before
			if (!isset($_SESSION['userid'])){ return getMessage("UserMustBeLoggedIn"); exit(); }
			if ($this->userVoted() == "0") {
				$query = $pdo->prepare("INSERT INTO ".TABLE_USERLIKE." VALUES (
					:userid,
					:entryid,
					:vote
					)");
				$res = $query->execute(array(
					':userid'=>$_SESSION['userid'],
					':entryid'=>$this->entryid,
					':vote'=>'1'
					));
				if ($res) {
					$query = $pdo->prepare("UPDATE ".TABLE_ENTRY." SET `tot_like` = :like WHERE `id` = ".$this->entryid);
					$this->like+=1;
					return $query->execute(array(':like'=>($this->like)));
				}
				else{ return getMessage("CannotVote"); }
			}
			else{ return getMessage("VotedBefore"); }
		}
	}
	public function addDislike(){
		if ($this->dislike==-1 || $this->entryid==-1){ return getMessage("EntryNotLoaded"); }
		else{
			$pdo = newPDO();
			// check if voted before
			if (!isset($_SESSION['userid'])){ return getMessage("UserMustBeLoggedIn"); exit(); }
			if ($this->userVoted() == "0") {
				$query = $pdo->prepare("INSERT INTO ".TABLE_USERLIKE." VALUES (
					:userid,
					:entryid,
					:vote
					)");
				$res = $query->execute(array(
					':userid'=>$_SESSION['userid'],
					':entryid'=>$this->entryid,
					':vote'=>'-1'
					));
				if($res) {
					$query = $pdo->prepare("UPDATE ".TABLE_ENTRY." SET `tot_dislike` = :dislike WHERE `id` = ".$this->entryid);
					$this->dislike+=1;
					return $query->execute(array(':dislike'=>($this->dislike)));
				}
				else{ return getMessage("CannotVote"); }
			}
			else{ return getMessage("VotedBefore"); }
		}
	}
	public function removeLike(){
		if ($this->like==-1 || $this->entryid==-1){ return getMessage("EntryNotLoaded"); }
		else{
			$pdo = newPDO();
			if (!isset($_SESSION['userid'])){ return getMessage("UserMustBeLoggedIn"); exit(); }
			if ($this->userVoted() != "0"){
				$query = $pdo->prepare("DELETE FROM ".TABLE_USERLIKE." WHERE userid=:userid AND entryid=:entryid");
				$res = $query->execute(array(
					':userid'=>$_SESSION['userid'],
					':entryid'=>$this->entryid
					));
				if ($res){
					$query = $pdo->prepare("UPDATE ".TABLE_ENTRY." SET `tot_like` = :like WHERE `id` = ".$this->entryid);
					$this->like-=1;
					return $query->execute(array(':like'=>($this->like)));
				}
				else{ return getMessage("CannotVote"); }
			}
		}
	}
	public function removeDislike(){
		if ($this->dislike==-1 || $this->entryid==-1){ return getMessage("EntryNotLoaded"); }
		else{
			$pdo = newPDO();
			if (!isset($_SESSION['userid'])){ return getMessage("UserMustBeLoggedIn"); exit(); }
			if ($this->userVoted() != "0"){
				$query = $pdo->prepare("DELETE FROM ".TABLE_USERLIKE." WHERE userid=:userid AND entryid=:entryid");
				$res = $query->execute(array(
					':userid'=>$_SESSION['userid'],
					':entryid'=>$this->entryid
					));
				if ($res){
					$query = $pdo->prepare("UPDATE ".TABLE_ENTRY." SET `tot_dislike` = :dislike WHERE `id` = ".$this->entryid);
					$this->dislike-=1;
					return $query->execute(array(':dislike'=>($this->dislike)));
				}
				else{ return getMessage("CannotVote"); }
			}
		}
	}


}