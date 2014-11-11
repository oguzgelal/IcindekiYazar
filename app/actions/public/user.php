<?php

if (isset($_GET['b'])){
	$uid = sanitize_string($_GET['b']);
	$user = new user($uid);
	if ($user->found == -1){
		errorPage("UserNotFound");
		exit();
	}
}
else{
	errorPage("Error404");
	exit();
}

?>
<!DOCTYPE html>
<html>
<head>
	<?php include_once dirname(__FILE__) . "/calls.php"; ?>
	<script src="/js/userPage.js"></script>
	<title><?php echo $user->name; ?></title>
</head>
<body id="<?php echo $user->id; ?>">

	<?php include_once dirname(__FILE__) . "/leftslidermenu.php"; ?>
	
	<!-- Header -->
	<header style="<?php echo bgimg($user->bgimage); ?>">
		<!-- Topbar -->
		<div class="topbar text-right">
			<ul class="list-unstyled list-inline">
				<li class="empty"></li>
				<?php
				if (isLoggedIn()){
					if ($user->id==$_SESSION['userid']){
						?><li><a class="reglink" href="/edit">Yeni Yazı</a></li><?php
					}
					else{
						?><li><a class="reglink" href="#">Paylaş</a></li><?php
						?><li><a class="reglink" href="#">Takip Et</a></li><?php
					}
				}
				else{ }
				?>
			</ul>
		</div>
		<div class="headercontainer">
			
			<!-- User Avatar -->
			<div class="col-xs-12 userAvatarHeader">
				<div class="avatarImage"><img src="<?php echo $user->image; ?>" alt="<?php echo $user->name; ?>"></div>
				<div class="avatarTitle"><?php echo $user->name; ?></div>
			</div>
		</div>
	</header>

	<div class="content">
		<!-- Content -->
		<div class="container user">
			<div class="revealbutton"><span class="revButton glyphicon glyphicon-circle-arrow-up"></span></div>
			
			<!-- Nav tabs -->
			<ul class="nav nav-tabs userpagenavs" role="tablist">
				<li class="active"><a href="#published" role="tab" data-toggle="tab">Yayımlananlar</a></li>
				<?php if ($user->id==$_SESSION['userid']){ ?>
				<li><a href="#unpublished" role="tab" data-toggle="tab">Taslaklar</a></li>
				<?php } ?>
			</ul>
			
			<!-- Tab panes -->
			<div class="tab-content">

				<!-- Published posts -->
				<div class="tab-pane active" id="published">
					<div class="stackscontainer clearfix" id="published">
						<div class="userstack col-sm-offset-1 col-sm-10 col-xs-12" id="published"></div>
					</div>
					<div class="loadmore" id="published"><button type="button" class="btn btn-default loadmorebutton" id="published">Daha fazla</button></div>
				</div>
				
				<!-- Unpublished posts -->
				<?php if ($user->id==$_SESSION['userid']){ ?>
				<div class="tab-pane" id="unpublished">
					<div class="stackscontainer clearfix">
						<div class="userstack col-sm-offset-1 col-sm-10 col-xs-12" id="unpublished"></div>
					</div>
					<div class="loadmore" id="unpublished"><button type="button" class="btn btn-default loadmorebutton" id="unpublished">Daha fazla</button></div>
				</div>
				<?php } ?>

			</div>


		</div>
	</div>


</body>
</html>