<?php

	namespace Jul;
	use PDO;

	class Users {

		static $usersCache	= [];

		public static function getUser($id) {
			$cache		= self::getFromCache($id);
			if ($cache) {
				return $cache;
			}
			$database	= Database::get();
			$userQ	= $database->prepare("SELECT * FROM `users` WHERE `id` = :id");
			$userQ->execute([':id' => 1]);
			$user	= $userQ->fetchAll(PDO::FETCH_CLASS, '\Jul\User');
			self::addToCache($user[0]);
			return $user[0];
		}

		public static function getUsers($ids) {
			$database	= Database::get();
			$placeholders	= Database::inize($ids);
			$userQ	= $database->prepare("SELECT * FROM `users` WHERE `id` IN ($placeholders)");
			$userQ->execute($ids);
			$usersT	= $userQ->fetch(PDO::FETCH_CLASS, '\Jul\User');
			$users	= [];
			foreach ($usersT as $user) {
				self::addToCache($user);
				$users[$user->id]	= $user;
			}

			// @TODO Check against cached ids
			return $users;

		}

		protected static function addToCache(User $user) {
			self::$usersCache[$user->id]	= $user;
		}

		protected static function getFromCache($id) {
			return (isset(self::$usersCache[$id])) ? self::$usersCache[$id] : null;
		}

	}
