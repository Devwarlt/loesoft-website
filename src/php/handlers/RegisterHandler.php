<?php
/**
 * Created by PhpStorm.
 * User: devwarlt
 * Date: 16/10/2019
 * Time: 13:22
 */

namespace php\handlers;

use php\utilities\Utils as utils;
use php\utilities\Database as db;

final class RegisterHandler implements IHandler
{
    private static $singleton;

    /**
     * Gets a singleton-like instance of **RegisterHandler** class.
     * @return RegisterHandler
     */
    public static function getSingleton()
    {
        if (self::$singleton === null)
            self::$singleton = new RegisterHandler();

        return self::$singleton;
    }

    /**
     * Handle a register message.
     * @param array $params
     * @return bool
     */
    public function handle(array $params)
    {
        $username = $params["username"];
        $password = $params["password"];

        if (utils::isNullOrEmpty($username) || utils::isNullOrEmpty($password)) return false;

        $db = db::getSingleton();

        return $db->insert("insert into accounts (username, password) values (':username', ':password')",
            array(
                ":username" => utils::getSha512Hash($username),
                ":password" => utils::getSha512Hash($password)
            ));
    }
}