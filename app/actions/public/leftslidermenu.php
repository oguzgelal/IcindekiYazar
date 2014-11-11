<!-- Left Slider Menu -->
<input type="checkbox" class="leftSliderMenuToggler" id="leftSliderMenuToggler">
<div class="leftSliderMenu">
	<label for="leftSliderMenuToggler"><span class="glyphicon glyphicon-align-justify leftSliderMenuTogglerIcon"></span></label>
	<ul>
		<?php
		if (!isLoggedIn()){ 
			?><a class="menulink" href="/index.php"><li><span class="glyphicon glyphicon-home menuicon"></span>Anasayfa</li></a><?php
			?><a class="menulink signinup" href="#"><li><span class="glyphicon glyphicon-log-in menuicon"></span>Giriş / Kaydol</li></a><?php
		}
		else {
			$userlsm = new user($_SESSION['userid']);
			?><a class="menulink profilebtn" id="<?php echo $userlsm->id; ?>" href="/user/<?php echo $userlsm->id; ?>"><li><img class="sliderprofileimg" src="<?php echo $userlsm->image; ?>" alt=""><?php echo $userlsm->name; ?></li></a><hr style="width:90%; border-color: rgba(211,211,211,0.5);"><?php
			?><a class="menulink" href="/"><li><span class="glyphicon glyphicon-home menuicon"></span>Anasayfa</li></a><?php
			?><a class="menulink" href="/edit"><li><span class="glyphicon glyphicon-pencil menuicon"></span>Yeni Yazı</li></a><?php
			?><a class="menulink logoutbtn" href="#"><li><span class="glyphicon glyphicon-log-out menuicon"></span>Oturumu kapat</li></a><?php
		}
		?>

	</ul>
</div>