<!DOCTYPE html>
<html>
<head>
	<?php include_once dirname(__FILE__) . "/calls.php"; ?>
	<title>Hata</title>
</head>
<body>
	<?php
	if (isset($_GET['b'])){
		$errormsg = getMessage($_GET['b']);
	}
	?>
	<div class="errorpage" style="text-align: center;">
		<h1 style="color:#a94442; font-weight:bolder; margin-bottom:30px;">Hata</h1>
		<div class="alert alert-danger" role="alert"><?php echo readable($errormsg); ?></div>
		<div class="errorbtndiv">
			<a href="#" class="backbutton" onclick="window.history.back();return false;" style="color:#a94442; margin-right: 15px;">Geri</a>
			<a href="/index.php" style="color:#a94442;">Anasayfa</a>
		</div>
	</div>

</body>
</html>