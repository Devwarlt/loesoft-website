<?php

namespace php\utilities;

include "Database.php";
include "Utils.php";

use \php\utilities\Database as db;
use \php\utilities\Utils as utils;

final class DatabaseUtils
{
	private static $singleton;
	
	public static function getSingleton()
	{
		if (self::$singleton === null)
			self::$singleton = new DatabaseUtils();
		
		return self::$singleton;
	}
	
	public function isAccountExist($username, $password)
	{
		$db = db::getSingleton();
		$result = 
			$db->select("select `id` from `accounts` where `username` = ':username' and `password` = ':password'",
				array(
                    ":username" => utils::getSha512Hash($username),
                    ":password" => utils::getSha512Hash($password)
				));
		
		return $result !== null;
	}
	
	public function getAccessLevelFromAccount($username, $password)
	{
		$db = db::getSingleton();
		$result = 
			$db->select("select `access_level` from `accounts` where `username` = ':username' and `password` = ':password'",
				array(
					":username" => $username,
					":password" => $password
				));
		
		if ($result === null) return -1;
		
		$account = $result->fetch(\PDO::FETCH_OBJ);
		
		return $account->access_level;
	}
	
	public function countNewsByLimit($limit)
	{
		$db = db::getSingleton();
		$result = 
			$db->select("select count(`id`) from `news`;");
		
		if ($result === null) return 0;
		
		return $result
	}
}