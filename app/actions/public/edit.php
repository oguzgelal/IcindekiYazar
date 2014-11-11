<?php

if (isset($_GET['b'])){
	$st = sanitize_string($_GET['b']);
	$essay = new essay($st);
	if ($essay->found==-1){
		errorPage("Error404");
		exit();
	}

	if(!isset($_SESSION['userid'])){
		errorPage("UserMustBeLoggedIn");
		exit();
	}

	if (!$essay->isOwner($_SESSION['userid'])){
		errorPage("NotYourPost");
		exit();
	}

}
else { $st = -1; }

?>
<!DOCTYPE html>
<html>
<head>
	<?php include_once dirname(__FILE__) . "/calls.php"; ?>
	<script src="/ckeditor/ckeditor.js"></script>
	<script src="/js/edit.js"></script>
	<title>İçindeki Yazar</title>
</head>
<body <?php if ($st != -1){ ?> id="<?php echo $essay->id; ?>" <?php } ?>>
	
	<?php include_once dirname(__FILE__) . "/leftslidermenu.php"; ?>

	<!-- Header -->
	<?php if ($st != -1){ ?> <input type="hidden" id="currentheaderimg" value="<?php echo $essay->image; ?>"> <?php } else { ?> <input type="hidden" id="currentheaderimg" value="<?php echo "/app/img/DefaultHeader/img1.jpg"; ?>">  <?php } ?>
	<header <?php if ($st != -1){ ?> style="background: url('<?php echo $essay->image; ?>'); background-size: cover; background-position: 0 50%;" <?php } else { ?> style="background: url(/app/img/DefaultHeader/img1.jpg); background-size: cover; background-position: 0 50%;" <?php } ?> >
		<!-- Topbar -->
		<div class="topbar locked text-right">
			<ul class="list-unstyled list-inline">
				<li class="empty"></li>
				<li><a class="reglink <?php if($st==-1){ echo"savebutton"; }else{echo"updatebutton";} ?>" href="#"> <?php if ($st==-1){ echo "Kaydet"; } else { echo"Kaydet"; } ?> </a></li>
				<li><a class="reglink previewbutton <?php if($st==-1){ echo"prevsave"; }else{echo"prevupdate";} ?>" href="#">Önizleme</a></li>
				<li><a class="reglink" href="<?php if($st==-1){ echo"/"; } else{echo"/essay/".$essay->id; } ?>">İptal</a></li>
			</ul>
		</div>
		<!-- Title -->
		<div class="headercontainer">
			<div class="col-xs-12 title" spellcheck="false" contenteditable="true"><?php if($st!=-1){ echo $essay->title; } ?></div> <!-- Title -->
			<div class="col-sm-10 col-sm-offset-1 col-xs-12 desc" spellcheck="false" contenteditable="true"><?php if($st!=-1){ echo $essay->desc; } ?></div> <!-- Description -->
		</div>
		<script>
		CKEDITOR.disableAutoInline = true;
		CKEDITOR.inline( 'editable' );
		</script>
		
		<!-- Header Images -->
		<div class="headerimgs">
			<ul class="list-inline list-unstyled text-right">
				<?php
				$defaultImgs = ["/app/img/DefaultHeader/img1.jpg", "/app/img/DefaultHeader/img2.jpg", "/app/img/DefaultHeader/img3.jpg", "/app/img/DefaultHeader/img4.jpg"];
				if ($st!=-1 && !in_array($essay->image, $defaultImgs)){ echo "<li class='imgbutton'><img src='".$essay->image."'></li>"; }
				foreach($defaultImgs as $di){ echo "<li class='imgbutton'><img src='".$di."'></li>"; }
				?>
				<li><a class="reglink addnewimagebutton" href="#">Ekle</a></li>
			</ul>
		</div>
	</header>

	<div class="content">

		<!-- Content -->
		<div class="container index">
			<div class="revealbutton"><span class="revButton glyphicon glyphicon-circle-arrow-up"></span></div>
			<div class="col-xs-12">
				<textarea class="ckeditor" name="ckeditor">
					<?php
					if($st!=-1){ echo $essay->getHtmlContent(); }
					?>
				</textarea>

			</div>
		</div>
	</div>


</body>
</html>