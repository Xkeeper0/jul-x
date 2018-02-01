<?php

	if (!$_SERVER['REQUEST_URI']) {
		$_SERVER['REQUEST_URI']	= $_SERVER['SCRIPT_NAME'] . ($_SERVER['QUERY_STRING'] ? "?". $_SERVER['QUERY_STRING'] : "");
	}

	$L['tr' ]	= "";
	$L['trh']	= "head";
	$L['trh2']	= "cat";
	$L['tr1']	= "bg1";
	$L['tr2']	= "bg2";
	$L['tr3']	= "bg3";
	$L['td' ]	= "bdr";
	$L['tdh']	= "bdr head";
	$L['tdh2']	= "bdr cat";
	$L['td1']	= "bdr bg1";
	$L['td2']	= "bdr bg2";
	$L['td3']	= "bdr bg3";
	$L['tdn']	= "nbdr";

	foreach($L as $key=>$val){
		$L[$key.'s'] = $L[$key] . " sfont";
	}
	foreach($L as $key => $val){
		$L[$key.'l']	= $L[$key] . " left";
		$L[$key.'c']	= $L[$key] . " center";
		$L[$key.'r']	= $L[$key] . " right";
	}

	foreach($L as $key => $val){
		$L[$key]	= "<". substr($key, 0, 2) ." class=\"". trim($L[$key]) . "\"";
	}

	$L['tr'] ='<tr';
//	$L[td] ='<td';
	$L['vtop']	= "valign=\"top\"";

	$L['tbl'] ='<table cellspacing="0" class="board"';
	$L['tbl1']='<table cellspacing="0" class="board c1"';
	$L['tbl2']='<table cellspacing="0" class="board c2"';
	$L['tblend']='</table>';

	$L['sm']	='<span class="sfont">';

	$L['inpt']='<input type="text" name';
	$L['inpp']='<input type="password" name';
	$L['inph']='<input type="hidden" name';
	$L['inps']='<input type="submit class="submit" name';
	$L['inpr']='<input type="radio" class="radio" name';
	$L['txta']='<textarea wrap="virtual" name';

	$L['sel'] ='<select name';
	$L['opt'] ='<option value';

	$signsep[0]='<br><br>--------------------<br>';
	$signsep[1]='<br><br>____________________<br>';
	$signsep[0]='<hr>';







  function pageheader($pagetitle='',$fid=0){
    global $L, $config, $sql;

	$themefile	= $theme['cssfile'];		// 3/11/2007 xkeeper - themes again

    if ($pagetitle)	{	$pagetitle	.= ' - ' . $config['boardtitle'];	}
	else			{	$pagetitle	= $config['boardtitle'];			}

	$sql -> query("INSERT INTO `julx` SET `ip` = '". $_SERVER['REMOTE_ADDR'] ."', `url` = '". addslashes($_SERVER['REQUEST_URI']) ."', `time` = '". ctime() ."'");

/*
    return	"<!DOCTYPE html PUBLIC \"-//W3C//DTD HTML 4.01 Transitional//EN\"
".			"   \"http://www.w3.org/TR/html4/loose.dtd\">
".	*/
	return	"<html>
".			"<head>
".			"	<title>$pagetitle</title>
".			"	<link rel=\"stylesheet\" href=\"themes/1.css\">
".			"</head>
".			"<body style=\"font-size: 80%;\">
".			"$L[tbl1]>
".			"	$L[tr]>$L[td1c] colspan=\"3\">". $config['boardlogo'] ."</td></tr>
".			"	$L[tr2c]>
".			"		$L[td] width=\"150\">Views: ?</td>
".			"		$L[td]>
".			"			<a href=\"./\">Main</a> - <a href=\"online.php\">Online users</a>
".			"		</td>
".			"		$L[td] width=\"150\">".date($config['dateformat'], ctime() + $loguser['tzoffset'])."</td>
".			"	</tr>
".			"	$L[tr1c]>
".			"		$L[td] colspan=3>
".			"			&nbsp;
".			"		</td>
".			"	</tr>
".			"$L[tblend]
";
  }



	function pagefooter(){
		global $config, $L, $sql;
		$time	= microtime(true) - $config['start'];
		return "<br>
".		"	$L[tbl2]>
".		"		$L[tr]>$L[td1c]>
".		"			Page rendered in ". number_format($time, 3) ." seconds.<br>
".		"			MySQL - queries: $sql->queries, rows: $sql->rowsf/$sql->rowst, time: ". number_format($sql->runtime, 3) ." seconds.
".		"		</td></tr>
".		"	$L[tblend]
".		"</body>
".		"</html>";
	}


	function errormsg($etext, $eurltext, $eurl) {
		global $config, $L, $sql;
		$time	= microtime(true) - $config['start'];
		return "
".		"	$L[tbl2]>
".		"		$L[tr]>$L[td1c]>
".		"			$etext<br>
".		"			<a href=\"$eurl\">$eurltext</a>
".		"		</td></tr>
".		"	$L[tblend]";
	}


?>
