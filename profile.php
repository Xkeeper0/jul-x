<?php

	require "inc/includes.inc.php";


	$user	= $sql -> fetchq(
		"SELECT `users`.*, ".
		"`schemes`.`name` as schemename ".
		"FROM `users` ".
		"LEFT JOIN `schemes` ON `users`.`scheme` = `schemes`.`id` ".
		"WHERE `users`.`id` = '". rint($_GET['id']) ."'");

	if (!$user) {
		die(pageheader("Error").
			"<a href=\"./\">". $config['boardtitle'] ."</a> - Error".
			errormsg("That user doesn't exist.", "Back", "./").
			"<a href=\"./\">". $config['boardtitle'] ."</a> - Error".
			pagefooter());
	}

	print pageheader() ."
".		"	<br>
".		"	$L[tbl1]>
".		"		$L[trh]>$L[td] colspan=\"2\">Profile for ". userlink($user['name'], $_GET['id'], $user['sex'], $user['powerlevel'], false) ."</td></tr>

".		"		$L[tr]>$L[td1c] width=\"200\">Posts</td>
".		"			$L[td2]>". number_format($user['posts']) ."</td></tr>
".		"		$L[tr]>$L[td1c]>Threads</td>
".		"			$L[td2]>". number_format($sql -> resultq("SELECT COUNT(*) FROM `threads` WHERE `user` = '". $_GET['id'] ."'")) ."</td></tr>
".		"		$L[tr]>$L[td1c]>EXP</td>
".		"			$L[td2]>&nbsp;</td></tr>
".		"		$L[tr]>$L[td1c]>Registered</td>
".		"			$L[td2]>". date($config['dateformat'], $user['regdate'] + $loguser['tzoffset']) ."</td></tr>
".		"		$L[tr]>$L[td1c]>Last post</td>
".		"			$L[td2]>". date($config['dateformat'], $user['lastposttime'] + $loguser['tzoffset']) ." (". timeunits(ctime() - $user['lastposttime']) ." ago)</td></tr>
".		"		$L[tr]>$L[td1c]>Last activity</td>
".		"			$L[td2]>". date($config['dateformat'], $user['lastactivity'] + $loguser['tzoffset']) ." (". timeunits(ctime() - $user['lastactivity']) ." ago)</td></tr>
".		"	$L[tblend]

".		"	<br>
".		"	$L[tbl1]>
".		"		$L[trh]>$L[td] colspan=\"2\">User settings</td></tr>

".		"		$L[tr]>$L[td1c] width=\"200\">Timezone Offset</td>
".		"			$L[td2]>". $user['timezone'] ." hours, etc.</td></tr>
".		"		$L[tr]>$L[td1c]>List options</td>
".		"			$L[td2]>". $user['threadsperpage'] ." threads, ". $user['postsperpage'] ." posts</td></tr>
".		"		$L[tr]>$L[td1c]>Color scheme</td>
".		"			$L[td2]>". $user['schemename'] ."</td></tr>
".		"		$L[tr]>$L[td1c]>?</td>
".		"			$L[td2]>?</td></tr>
".		"	$L[tblend]
".		pagefooter();


?>