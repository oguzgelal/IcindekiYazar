<!DOCTYPE html>
<html>
<head>
	<?php include_once dirname(__FILE__) . "/calls.php"; ?>
	<script src="/js/try.js"></script>
	<script src="/js/indexPage.js"></script>
	<title>İçindeki Yazar</title>
</head>
<body>

	<?php include_once dirname(__FILE__) . "/leftslidermenu.php"; ?>

	<!-- Header -->
	<header style="<?php echo bgimg("/app/img/DefaultHeader/img".rand(1,4).".jpg"); ?>">
		<!-- Topbar -->
		<div class="topbar text-right">
			<ul class="list-unstyled list-inline">
				<li class="empty"></li>
				<?php
				if (isLoggedIn()){
					$user = new user($_SESSION['userid']);
				}
				else{ }
				?>
			</ul>
		</div>
		<div class="headercontainer">
			<!-- Title -->
			<div class="col-xs-12 title">İçindeki Yazar</div>
		</div>
	</header>

	<div class="content">
		<!-- Content -->
		<div class="container index">
			<div class="revealbutton"><span class="revButton glyphicon glyphicon-circle-arrow-up"></span></div>
			<div class="stackscontainer clearfix"></div>
			<div class="loadmore"><button type="button" class="btn btn-default loadmorebutton">Daha fazla</button></div>
		</div>
	</div>

</body>
</html>