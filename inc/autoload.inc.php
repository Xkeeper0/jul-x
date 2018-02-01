<?php

	// Autoload
	function julx_autoloader($class) {
		$file	= __DIR__ ."/classes/". str_replace('\\', '/',$class) .".php";
		if (file_exists($file)) {
			require_once($file);
		}
	}
	spl_autoload_register("julx_autoloader");
