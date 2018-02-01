<?php

	$config['start']	= microtime(true);

	// functions are a wonderful thing that aren't here yet




	function rint(&$val) {
		$val	= intval($val);
		return $val;
	}

	function ctime() {
		global $config;
		return time() + $config['timeoffset'];
	}

	function userlink($name, $id, $sex, $power, $linkify = true) {
//		$linkify		= false;

		if ($power == -1) $power = "x";
		if ($sex <= 2)	{	$color	= "class=\"nc$sex$power". ($linkify ? "" : " bold") ."\"";	}
		else			{	$color	= "style=\"color: #f99; font-style: italic;\"";	}
		if ($linkify)	{	return "<a href=\"profile.php?id=$id\"><span $color>$name</span></a>";	}
		else			{	return "<span $color>$name</span>";							}
	}




	function timeunits($sec){
		if($sec<    60) return "$sec sec.";
		if($sec<  3600) return floor($sec/60).' min.';
		if($sec< 86400) return floor($sec/3600).' hour'.($sec>=7200?'s':'');
		return floor($sec/86400).' day'.($sec>=172800?'s':'');
	}

	function timeunits2($sec){
		$d=floor($sec/86400);
		$h=floor($sec/3600)%24;
		$m=floor($sec/60)%60;
		$s=$sec%60;
		$ds=($d>1?'s':'');
		$hs=($h>1?'s':'');
		$str=($d?"$d day$ds ":'').($h?"$h hour$hs ":'').($m?"$m min ":'').($s?"$s sec":'');
		if(substr($str,-1)==' ') $str=substr_replace($str,'',-1);
		return $str;
	}






	// board2 filters
	// need to update it with 1.92 ones, too (what a joke...)
	function postfilter($msg){

		$msg=str_replace("\n","\n<br>",$msg);
		$tags=array('script', 'iframe', 'textarea', 'noscript', 'meta', 'xmp', 'plaintext', 'embed');
		foreach($tags as $tag){
			$msg=preg_replace("'<$tag(.*?)>'si" ,"&lt;$tag\\1>" ,$msg);
			$msg=preg_replace("'</$tag(.*?)>'si","&lt;/$tag>",$msg);
		}

		$msg=preg_replace("' on([a-z]*)([ ]*?)?='si",' on\\1&#61;',$msg);	// might not work so well.
		$msg=preg_replace("'filter:'si",'filter&#58;>',$msg);
		$msg=preg_replace("'javascript:'si",'javascript&#58;>',$msg);
		$msg=preg_replace("'\[(b|i|u|s)\]'si",'<\\1>',$msg);
		$msg=preg_replace("'\[/(b|i|u|s)\]'si",'</\\1>',$msg);
		$msg=str_replace('[spoiler]','<div style=color:black;background:black class=fonts><font color=white><b>Spoiler:</b></font><br>',$msg);
		$msg=str_replace('[/spoiler]','</div>',$msg);
		$msg=preg_replace("'\[url\](.*?)\[/url\]'si",'<a href="\\1">\\1</a>',$msg);
		$msg=preg_replace("'\[url=(.*?)\](.*?)\[/url\]'si",'<a href="\\1">\\2</a>',$msg);
		$msg=preg_replace("'\[img\](.*?)\[/img\]'si",'<img src="\\1" alt="">',$msg);
		$msg=str_replace('[quote]','<blockquote><hr>',$msg);
		$msg=str_replace('[/quote]','<hr></blockquote>',$msg);
		$msg=preg_replace("'\[reply=\"(.*?)\" id=\"(.*?)\"\]'si",'<blockquote><small><i><a href=showprivate.php?id=\\2>Sent by \\1</a></i></small><hr>',$msg);
		$msg=preg_replace("'\[quote=\"(.*?)\" id=\"(.*?)\"\]'si",'<blockquote><small><i><a href=thread.php?pid=\\2#\\2>Posted by \\1</a></i></small><hr>',$msg);
		$msg=preg_replace("'\[quote=(.*?)\]'si",'<blockquote><i>Posted by \\1</i><hr>',$msg);

		return $msg;
	}


?>
