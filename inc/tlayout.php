<?php


	function postout($postdata, $settings = array()) {
		global $config, $L, $loguser;

		return "
"			."	$L[tbl1]>
"			."		$L[tr1]>
"			."			$L[td] rowspan=\"2\" width=\"200\" $L[vtop]>". userlink($postdata['uname'], $postdata['uid'], $postdata['usex'], $postdata['upower']) ."
"			."				<br>$L[sm] Post". ($postdata['num'] ? " ". $postdata['num'] ."/" : "s:") . $postdata['uposts'] ."
"			."				<br>
"			."				<br>Last activity: ". timeunits(ctime() - $postdata['uactive']) ."
"			."				<br></span>
"			."			</td>
"			."			$L[tds]>Posted ". date($config['dateformat'], $postdata['date'] + $loguser['tzoffset']) ."</td>
"			."		</tr>
"			."		$L[tr2]>
"			."			$L[td] $L[vtop]>". postfilter($postdata['uhead'] . $postdata['text'] ."<br><br>------<br>". $postdata['usig']) ."<br>&nbsp;</td>
"			."		</tr>
"			."	$L[tblend]";
	}

?>