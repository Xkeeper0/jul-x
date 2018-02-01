<?php

	require "inc/includes.inc.php";

	$time	= abs((rint($_GET['time']) ? $_GET['time'] : $config['onlinetime']));

	$tlink	= "<a href=\"?time=";

	print pageheader("Online Users") ."
".		"
".		"	Online users in the last ". timeunits2($time) .":
".		"	<br>$L[sm]Show: {$tlink}60\">last minute</a> - {$tlink}300\">five minutes</a> - {$tlink}900\">15 minutes</a> - {$tlink}3600\">hour</a> - {$tlink}86400\">day</a></span>
".		"	$L[tbl1]>
".		"		$L[trh]>
".		"			$L[td] colspan=\"2\">User</td>
".		"			$L[td]>Last Activity</td>
".		"			$L[td]>Last Post</td>
".		"			$L[td]>Page</td>
".		"			$L[td]>Posts</td>
".		"		</tr>
".		"		$L[trh2]>
".		"			$L[td] colspan=\"6\">Users</td>
".		"		</tr>";


	$userlist	= $sql -> query(
		"SELECT * FROM `users` ".
		"WHERE `lastactivity` > '". (ctime() - $time) ."' ".
		"ORDER BY `lastactivity` DESC");
	while ($user = $sql -> fetch($userlist)) {
		$i++;
		print "
".		"		$L[tr]>
".		"			$L[td2c]>$i</td>
".		"			$L[td1]>". userlink($user['name'], $user['id'], $user['sex'], $user['powerlevel'], true) ."</td>
".		"			$L[td2c]>". date($config['timeformat'], $user['lastactivity'] + $loguser['tzoffset']) ."</td>
".		"			$L[td2c]>". ($user['lastposttime'] ? date($config['dateformat'], $user['lastactivity'] + $loguser['tzoffset']) : "-") ."</td>
".		"			$L[td1]><a href=\"http://jul.rustedlogic.net". $user['lasturl'] ."\">". $user['lasturl'] ."</a></td>
".		"			$L[td2c]>". $user['posts'] ."</td>
".		"		</tr>";
		

	}

	if ($i == 0) print "
".		"		$L[tr]>$L[td1c] colspan=\"6\">No users online</td></tr>";

	print "
".		"		$L[trh2]>
".		"			$L[td] colspan=\"6\">Guests</td>
".		"		</tr>";

	$guestlist	= $sql -> query(
		"SELECT * FROM `guests` ".
		"WHERE `date` > '". (ctime() - $time) ."' ".
		"ORDER BY `date` DESC");
	$i	= 0;
	while ($guest = $sql -> fetch($guestlist)) {
		$i++;
		print "
".		"		$L[tr]>
".		"			$L[td2c]>$i</td>
".		"			$L[td1]>". $guest['ip'] ."</td>
".		"			$L[td2c]>". date($config['timeformat'], $guest['date'] + $loguser['tzoffset']) ."</td>
".		"			$L[td2c]>&nbsp;</td>
".		"			$L[td1] colspan=\"2\"><a href=\"http://jul.rustedlogic.net". $guest['lasturl'] ."\">". $guest['lasturl'] ."</a></td>
".		"		</tr>";
		

	}
	if ($i == 0) print "
".		"		$L[tr]>$L[td1c] colspan=\"6\">No guests online</td></tr>";



	print "
".		"		$L[trh2]>
".		"			$L[td] colspan=\"6\">Jul X</td>
".		"		</tr>";

	$xguestlist	= $sql -> query(
		"SELECT * FROM `julx` ".
		"WHERE `time` > '". (ctime() - $time) ."' ".
		"ORDER BY `time` DESC");
	$i	= 0;
	while ($guest = $sql -> fetch($xguestlist)) {
		$i++;
		print "
".		"		$L[tr]>
".		"			$L[td2c]>$i</td>
".		"			$L[td1]>". $guest['ip'] ."</td>
".		"			$L[td2c]>". date($config['timeformat'], $guest['time'] + $loguser['tzoffset']) ."</td>
".		"			$L[td2c]>&nbsp;</td>
".		"			$L[td1] colspan=\"2\"><a href=\"". $guest['url'] ."\">". $guest['url'] ."</a></td>
".		"		</tr>";
	}
	if ($i == 0) print "
".		"		$L[tr]>$L[td1c] colspan=\"6\">No guests online</td></tr>";
		


	print "
".		"</table>
".		pagefooter();



?>