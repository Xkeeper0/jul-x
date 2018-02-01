<?php

	require "inc/includes.inc.php";


	$out	= pageheader() . "
".					"<br>
".					"$L[tbl1]>
".					"	$L[trh]>
".					"		$L[td] colspan=\"2\">Name</td>
".					"		$L[td]>Threads</td>$L[td]>Posts</td>
".					"		$L[td]>Last Post</td>
".					"	</tr>";





	$cats	= $sql -> query("SELECT * ".
							"FROM `categories` ".
							"WHERE `minpower` <= 0 ".
							"ORDER BY `id` ASC");
	while ($cat = $sql -> fetch($cats)) {
		$cattext[$cat['id']]	.= "
".					"	$L[trh2]>
".					"		$L[td] colspan=\"5\">". $cat['name'] ."</td>
".					"	</tr>";

	}


	$forums	= $sql -> query("SELECT `forums`.*, ".
							"`users`.`id` as uid, ".
							"`users`.`sex` as usex, ".
							"`users`.`powerlevel` as upower, ".
							"`users`.`name` as uname ".
							"FROM `forums` ".
							"LEFT JOIN `users` ON `users`.`id` = `forums`.`lastpostuser` ".
							"WHERE `minpower` <= 0 ".
							"ORDER BY `forums`.`catid` ASC, `forums`.`forder` ASC");

	while ($forum = $sql -> fetch($forums)) {

		$cattext[$forum['catid']]	.= "
".					"	$L[tr]>
".					"		$L[td2]>&nbsp;</td>
".					"		$L[td1]><a href=\"forum.php?id=". $forum['id'] ."\">". $forum['title'] ."</a>
".					"			<br>$L[sm]". $forum['description'] ."</span></td>
".					"		$L[td2c]>". $forum['numthreads'] ."</td>$L[td2c]>". $forum['numposts'] ."</td>
".					"		$L[td1c]>". date($config['dateformat'], $forum['lastpostdate'] + $loguser['tzoffset']) ."
".					"			<br>$L[sm]by ". userlink($forum['uname'], $forum['uid'], $forum['usex'], $forum['upower']) ."</span></td>
".					"	</tr>";

	}

	$out	.= implode("", $cattext);

	$out	.= "\n</table>";

	print $out;

	print pagefooter();

?>