<?php

	require "inc/includes.inc.php";


	$forum		= $sql -> fetchq("SELECT * FROM `forums` WHERE `id` = '". rint($_GET['id']) ."'");

	if (!$forum) {
		die(pageheader("Error").
			"<a href=\"./\">". $config['boardtitle'] ."</a> - Error".
			errormsg("That forum doesn't exist.", "Back", "./").
			"<a href=\"./\">". $config['boardtitle'] ."</a> - Error".
			pagefooter());

	} elseif ($forum['minpower'] > $loguser['powerlevel'] && !$_GET['sekret']) {
		die(pageheader("Error") . errormsg("You are not allowed to access this forum.", "Back", "./") . pagefooter());
	}
	
	print pageheader($forum['title']) ."
".					"<a href=\"./\">". $config['boardtitle'] ."</a> - ". $forum['title'] ."
".					"$L[tbl1]>
".					"	$L[trh]>
".					"		$L[td] colspan=\"3\">Name</td>
".					"		$L[td]>Started by</td>
".					"		$L[td]>Replies</td>$L[td]>Views</td>
".					"		$L[td]>Last Post</td>
".					"	</tr>";

	$threads	= $sql -> query(
		"SELECT `threads`.*, ".
		"`u1`.`id` as u1id, ".
		"`u1`.`sex` as u1sex, ".
		"`u1`.`powerlevel` as u1power, ".
		"`u1`.`name` as u1name, ".
		"`u2`.`id` as u2id, ".
		"`u2`.`sex` as u2sex, ".
		"`u2`.`powerlevel` as u2power, ".
		"`u2`.`name` as u2name ".
		"FROM `threads` ".
		"LEFT JOIN `users` `u1` ON `u1`.`id` = `threads`.`user` ".
		"LEFT JOIN `users` `u2` ON `u2`.`id` = `threads`.`lastposter` ".
		"WHERE `forum` = '". $_GET['id'] ."' ".
		"ORDER BY `sticky` DESC, `lastpostdate` DESC ".
		"LIMIT 0, 50");

	$sticky		= false;
	while ($thread = $sql -> fetch($threads)) {

		if ($sticky && !$thread['sticky']) {
			$tlist	.= "
".					"	$L[trh]>
".					"		$L[td] colspan=\"7\"><img src=\"img/blank.png\" width=\"5\" height=\"5\"></td>
".					"	</tr>";
		}
		$tlist	.= "
".					"	$L[tr]>
".					"		$L[td2]>&nbsp;</td>
".					"		$L[td2]>&nbsp;</td>
".					"		$L[td1]><a href=\"thread.php?id=". $thread['id'] ."\">". $thread['title'] ."</a></td>
".					"		$L[td2c]>". userlink($thread['u1name'], $thread['u1id'], $thread['u1sex'], $thread['u1power']) ."</td>
".					"		$L[td2c]>". $thread['replies'] ."</td>$L[td2c]>". $thread['views'] ."</td>
".					"		$L[td1c]>". date($config['dateformat'], $thread['lastpostdate'] + $loguser['tzoffset']) ."
".					"			<br>$L[sm]by ". userlink($thread['u2name'], $thread['u2id'], $thread['u2sex'], $thread['u2power']) ."</span></td>
".					"	</tr>";

		$sticky	= $thread['sticky'];

	}

	if (!$tlist) {
		$tlist	= "
".					"	$L[tr]>
".					"		$L[td2c] colspan=\"7\">No threads</td>
".					"	</tr>";
	}

	print $tlist ."
".		"	$L[tblend]
".		"<a href=\"./\">". $config['boardtitle'] ."</a> - ". $forum['title'] ."
".		pagefooter();

?>