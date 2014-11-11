<?php
class user {

	public $id = -1;
	public $found = -1;

	public $email = "";
	public $name = "";
	public $password = "";
	public $regtime;
	public $image = "/app/img/Avatar/default.png";
	public $bgimage = "/app/img/DefaultHeader/img1.jpg";
	public $type = USER;

	public function user($id = false){
		if($id){ $this->Load($id); }
	}

	public static function getName($uid){
		$pdo = newPDO();
		$query = $pdo->prepare("SELECT name FROM ".TABLE_USER." WHERE id=:id LIMIT 1");
		$query->execute(array(':id'=>$uid));
		$results = $query->fetchAll(PDO::FETCH_ASSOC);
		return $results[0]['name'];
	}

	public function Load($id){
		$this->id = $id;
		$pdo = newPDO();
		$query = $pdo->prepare("SELECT * FROM ".TABLE_USER." WHERE id=:id LIMIT 1");
		$query->execute(array(':id'=>$this->id));
		$results = $query->fetchAll(PDO::FETCH_ASSOC);
		if (count($results) > 0) {
			$this->found = 1;
			foreach($results as $r){
				$this->email = $r['email'];
				$this->password = $r['password'];
				$this->name = $r['name'];
				$this->regtime = $r['regtime'];
				$this->image = $r['image'];
				$this->bgimage = $r['bgimage'];
				$this->type = $r['type'];
			}
		}
		else{ $found = 0; }
	}

	// static
	// if id is set, it checks if a user exists that has the email $email and doesnt have the id $id
	public static function userExists($email, $id=false){
		$pdo = newPDO();
		if ($id){
			$query = $pdo->prepare("SELECT * FROM ".TABLE_USER." WHERE email=:email AND id<>:id LIMIT 1");
			$query->execute(array(':email'=>$email, ':id'=>$id));
			$results = $query->fetchAll(PDO::FETCH_ASSOC);
		}
		else {
			$query = $pdo->prepare("SELECT * FROM ".TABLE_USER." WHERE email=:email LIMIT 1");
			$query->execute(array(':email'=>$email));
			$results = $query->fetchAll(PDO::FETCH_ASSOC);
		}
		if (count($results) > 0) { return 1; }
		else{ return 0; }
	}

	public function insert(){
		if ($this->email == ""){ return getMessage("MissingUserData", "E-posta"); }
		else if ($this->name == ""){ return getMessage("MissingUserData", "İsim"); }
		else if ($this->password == ""){ return getMessage("MissingUserData", "Şifre"); }
		else if ($this->userExists($this->email) == 1){ return getMessage("EmailInUse"); }
		else{
			if ($this->regtime==""){ $this->regtime = time(); }
			$pdo = newPDO();
			$query = $pdo->prepare("INSERT INTO ".TABLE_USER." VALUES (
				:id,
				:email,
				:password,
				:name,
				:regtime,
				:image,
				:bgimage,
				:type
				)");

			$res = $query->execute(array(
				':id'=>'',
				':email'=>$this->email,
				':password'=>$this->password,
				':name'=>$this->name,
				':regtime'=>$this->regtime,
				':image'=>$this->image,
				':bgimage'=>$this->bgimage,
				':type'=>$this->type
				));
			$this->id  = $pdo->lastInsertId();
			if ($res){ return getMessage("UserAdded", $this->id); }
			else { return getMessage("UserNotAdded"); }
		}
	}

	public function update(){
		if ($this->userExists($this->email, $this->id)==1){ return getMessage("EmailInUse"); }
		else{
			$pdo = newPDO();
			$query = $pdo->prepare("UPDATE ".TABLE_USER." SET 
				`email` = :email, 
				`password` = :password,
				`name` = :name,
				`image` = :image,
				`bgimage` = :bgimage,
				`user` = :user
				WHERE `id` = ".$this->id);

			$res = $query->execute(array(
				':email'=>$this->email, 
				':password'=>$this->password,
				':name'=>$this->name,
				':image'=>$this->image,
				':bgimage'=>$this->bgimage,
				':user'=>$this->user
				));

			if ($res){ return getMessage("UserUpdated"); }
			else { return getMessage("UserNotUpdated"); }
		}
	}

	// static
	public static function delete($userid=false){
		if ($userid){ $this->id = $userid; }
		$pdo = newPDO();
		$query = $pdo->prepare("DELETE FROM ".TABLE_USER." WHERE id=:id");
		$res = $query->execute(array(':id'=>$this->id));
		if ($res){ return getMessage("UserDeleted"); }
		else { return getMessage("UserNotDeleted"); }
	}

}