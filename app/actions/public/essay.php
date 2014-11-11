<?php

if (isset($_GET['b'])){
	$st = sanitize_string($_GET['b']);
	$essay = new essay($st);
	if ($essay->found==-1){
		errorPage("Error404");
		exit();
	}
	$entry = new entry();
	$entry->LoadByPid($essay->id, "essay");
	if ($entry->found==-1 || $entry->entryid==-1){
		errorPage("Error404");
		exit();
	}
}
else {
	errorPage("Error404");
	exit();
}

?>
<!DOCTYPE html>
<html>
<head>
	<?php include_once dirname(__FILE__) . "/calls.php"; ?>
	<title>İçindeki Yazar</title>
</head>
<body <?php if ($st != -1){ ?> id="<?php echo $essay->id; ?>" <?php } ?>>

	<?php include_once dirname(__FILE__) . "/leftslidermenu.php"; ?>

	<!-- Header -->
	<header <?php if ($st != -1){ ?> style="background: url('<?php echo $essay->image; ?>'); background-size: cover; background-position: 0 50%;'" <?php } ?> >
		<!-- Topbar -->
		<div class="topbar text-right">
			<ul class="list-unstyled list-inline">
				<li class="empty"></li>
				<?php if (isset($_SESSION['userid']) && $essay->isOwner($_SESSION['userid'])){ ?>
				<li><a class="reglink" href="/edit/<?php echo $essay->id; ?>">Düzenle</a></li>
				<li>
					<?php
					if ($essay->isPublished() == 0){ ?> <a class="reglink publishbutton" id="<?php echo $entry->entryid; ?>" href="#">Yayımla</a> <?php }
					else{ ?> <a class="reglink unpublishbutton" id="<?php echo $entry->entryid; ?>" href="#">Yayımdan kaldır</a> <?php } ?>
				</li>
				<?php } else { ?>
				<li><a class="reglink" href="/user/<?php echo $essay->userid; ?>"><?php echo $essay->getAuthor(); ?></a><span style='font-size: 11px;'></span></li>
				<?php } ?>
			</ul>
		</div>
		<div class="headercontainer">
			<div class="col-xs-12 title"><?php if($st!=-1){ echo $essay->title; } ?></div> <!-- Title -->
			<div class="col-sm-10 col-sm-offset-1 col-xs-12 desc"><?php if($st!=-1){ echo $essay->desc; } ?></div> <!-- Description -->
		</div>
	</header>

	<div class="content">
		<!-- Revealbar -->
		<div class="revealbar" <?php if ($st != -1){ ?> style="background: url('<?php echo $essay->image; ?>'); background-size: cover; background-position: 0 50%;'" <?php } ?>>
			<div class="revealbar_elem revealbar_title"><?php if($st!=-1){ echo $essay->title; } ?></div>
			<div class="revealbar_elem revealbar_links">
				<ul class="list-unstyled list-inline">
					<li><span class="topButton glyphicon glyphicon-circle-arrow-up" style="font-size: 27px; padding-top: 8px;"></span></li>
				</ul>
			</div>
		</div>
		<!-- Content -->
		<div class="container essay">
			<div class="revealbutton"><span class="revButton glyphicon glyphicon-circle-arrow-up"></span></div>
			<div class="col-lg-9 col-xs-12" style='margin-bottom: 30px;'>
				<?php
				// Vote System

				$likevoted = "";
				$dislikevoted = "";
				if ($entry->userVoted() == "1"){ $likevoted = "voted"; }
				else if ($entry->userVoted() == "-1") { $dislikevoted = "voted"; }

				?>
				<div class="essaysocial">
					<div class="essaysocialcol <?php echo $likevoted; ?> esclikedislike esclike" id="<?php echo $entry->entryid; ?>">
						<span class="glyphicon glyphicon-thumbs-up" style="font-size: 25px; margin-right: 5px;"></span><span class="esclike_text"><?php echo $entry->like; ?></span>
					</div>
					<div class="essaysocialcol <?php echo $dislikevoted; ?> esclikedislike escdislike" id="<?php echo $entry->entryid; ?>">
						<span class="glyphicon glyphicon-thumbs-down" style="font-size: 25px; margin-right: 5px;"></span><span class="escdislike_text"><?php echo $entry->dislike; ?></span>
					</div>
					<div class="essaysocialcol escfb">Facebook</div>
					<div class="essaysocialcol esctwtr">Twitter</div>
					<!--<div class="essaysocialcol escmore"></div>-->
					<div class="clearfix"></div>
				</div>
				<?php 
				if($st!=-1){ echo $essay->getHtmlContent(); }
				?>
			</div>
			<div class="col-lg-3 col-xs-12">
				<div class="essayrightpane">
					<?php
						// other posts from users
					$recomusr = entry::loadUserEntries($essay->userid, "latest", "card", "any", "0", "3", "published");
					if (count($recomusr) > 1){
						echo "<div class='sidetitle'>".$essay->getAuthor()."</div>";
						foreach($recomusr as $rusr){
							if ($rusr['postid'] != $essay->id){
								$post = getEntryObject(new entry($rusr['id']));
								if ($post != null){ echo $post->cardHtml(); }
							}
						}
					}
						// recent posts
					$recom = entry::loadEntries("latest", "card", "any", "0", "2");
					if (count($recom) > 0){
						echo "<div class='sidetitle'>Yeniler</div>";
						foreach($recom as $r){
							$post = getEntryObject(new entry($r['id']));
							if ($post != null){ echo $post->cardHtml(); }
						}
					}
					?>
				</div>
			</div>
		</div>
	</div>


</body>
</html>