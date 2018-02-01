<?php

	namespace Jul;

	class Database extends \PDO {

		static $instance	= null;

		static public function get() {
			return self::$instance;
		}

		static public function connect($host, $user, $password, $database) {
			if (self::$instance) {
				return self::$instance;
			} else {
				self::$instance	= new Database("mysql:dbname=$database;host=$host", $user, $password);
				return self::$instance;

			}
		}


		static public function inize($array) {
			$placeholders = implode(',', array_fill(0, count($array), '?'));
			return $placeholders;
		}

	}
