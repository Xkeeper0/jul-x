<?php

	require "inc/includes.inc.php";


	$thread			= $sql -> fetchq(
		"SELECT `threads`.*, ".
//		"`forums`.`id` AS 'fid', ".
		"`forums`.`title` AS 'fname', ".
		"`forums`.`minpower` AS 'fminpower' ".
		"FROM `threads` ".
		"LEFT JOIN `forums` ON `forums`.`id` = `threads`.`forum` ".
		"WHERE `threads`.`id` = '". rint($_GET['id']) ."'");

	if (!$thread) {
		die(pageheader("Error").
			"<a href=\"./\">". $config['boardtitle'] ."</a> - Error".
			errormsg("That thread doesn't exist.", "Back", "./").
			"<a href=\"./\">". $config['boardtitle'] ."</a> - Error".
			pagefooter());

	} elseif ($thread['fminpower'] > $loguser['powerlevel'] && !$_GET['sekret']) {
		die(pageheader("Error") . errormsg("You  are not allowed to access this thread.", "Back", "./") . pagefooter());
	}



	$link	= "
".			"<a href=\"./\">". $config['boardtitle'] ."</a> - <a href=\"forum.php?id=". $thread['forum'] ."\">". $thread['fname'] ."</a> - ". $thread['title'];

	print pageheader($thread['title'] ." - ". $thread['fname']) . $link;

//	print "<pre>";
//	print_r($thread);
//	die();
	

	$pdata			= $sql -> query(
		"SELECT `posts`.*, ".
		"`posts_text`.*, ".
		"`users`.`id` AS 'uid', ".
		"`users`.`name` AS 'uname', ".
		"`users`.`powerlevel` AS 'upower', ".
		"`users`.`sex` AS 'usex', ".
		"`users`.`posts` AS 'uposts', ".
		"`users`.`postheader` AS 'uhead', ".
		"`users`.`signature` AS 'usig', ".
		"`users`.`lastactivity` AS 'uactive' ".
		"FROM `posts` ".
		"LEFT JOIN `posts_text` ON `posts_text`.`pid` = `posts`.`id` ".
		"LEFT JOIN `users` ON `users`.`id` = `posts`.`user` ".
		"WHERE `posts`.`thread` = '". $_GET['id'] ."' ".
		"ORDER BY `date` ASC ".
		"LIMIT ". max(0, $thread['replies'] - 50) .", 50 "
		);

	while ($data = $sql -> fetch($pdata)) {
		print postout($data);
	}

	print $link . pagefooter();


		/*
		return "
"			."	$L[tbl1]>
"			."		$L[tr1]>
"			."			$L[td] rowspan=\"2\">". userlink($postdata['uname'], $postdata['uid'], $postdata['upower'], $postdata['usex']) ."
"			."				<br>Post(s): ". $postdata['post'] ."/". $postdata['uposts'] ."
"			."				<br>
"			."			</td>
"			."			$L[td]>~</td>
"			."		</tr>
"			."		$L[tr2]>
"			."			$L[td]>". $postdata['ptext'] ."</td>
"			."		</tr>
"			."	$L[tblend]";
	}
*/
?>