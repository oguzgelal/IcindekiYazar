<?php

$entryid = sanitize_string($_POST['entryid']);
$vote = sanitize_string($_POST['vote']);

$entryToVote = new entry($entryid);

if($vote == "like"){
	echo $entryToVote->addLike();
}
else if ($vote == "dislike"){
	echo $entryToVote->addDislike();
}
else if ($vote == "removelike"){
	echo $entryToVote->removeLike();
}
else if ($vote == "removedislike"){
	echo $entryToVote->removeDislike();
}
else if ($vote == "like_removedislike"){
	$rmdislike = $entryToVote->removeDislike();
	if (isError($rmdislike) == 1){ echo $rmdislike;	}
	else{ echo $entryToVote->addLike();	}
}
else if ($vote == "dislike_removelike"){
	$rmlike = $entryToVote->removeLike();
	if (isError($rmlike) == 1){ echo $rmlike;	}
	else{ echo $entryToVote->addDislike();	}
}

// TODO : add removeLike removeDislike