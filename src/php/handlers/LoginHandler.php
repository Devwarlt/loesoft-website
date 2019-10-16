<?php
/**
 * Created by PhpStorm.
 * User: devwarlt
 * Date: 16/10/2019
 * Time: 12:34
 */

namespace php\handlers;

include "../utilities/DateUtils.php";
include "../utilities/Utils.php";
include "../utilities/Database.php";

use php\utilities\DateUtils as dutils;
use php\utilities\Utils as utils;
use php\utilities\Database as db;

define("LOGIN_USERNAME", "login-username-cookie");
define("LOGIN_PASSWORD", "login-password-cookie");
define("LOGIN_LEVEL", "login-access-level-cookie");


final class LoginHandler implements IHandler
{
    private static $singleton;

    /***
     * Gets a singleton-like instance of **LoginHandler** class.
     * @return LoginHandler
     */
    public static function getSingleton()
    {
        if (self::$singleton === null)
            self::$singleton = new LoginHandler();

        return self::$singleton;
    }

    /***
     * Handle a login message.
     * @param array $params
     */
    public function handle(array $params)
    {
        if ($this->isLoggedIn()) return;

        $username = $params["username"];
        $password = $params["password"];
        $db = db::getSingleton();
        $result =
            $db->select("select `access_level` from `accounts` where `username` = ':username' and `password` = ':password'",
                array(
                    ":username" => utils::getSha512Hash($username),
                    ":password" => utils::getSha512Hash($password)
                ));

        if ($result === null) return;

        $account = $result->fetch(\PDO::FETCH_OBJ);
        $this->setLoginCookies($username, $password, $account->acces_level);
    }

    /***
     * Verify if user is already logged in.
     * @return bool
     */
    public function isLoggedIn()
    {
        return array_key_exists(LOGIN_USERNAME, $_COOKIE) && array_key_exists(LOGIN_PASSWORD, $_COOKIE);
    }

    /***
     * Set current login session cookies.
     * @param $username
     * @param $password
     * @param $accessLevel
     */
    private function setLoginCookies($username, $password, $accessLevel)
    {
        $expire = dutils::getCurrentTimeAddition(dutils::getHour());
        $path = "/";

        setcookie(LOGIN_USERNAME, utils::getSha512Hash($username), $expire, $path);
        setcookie(LOGIN_PASSWORD, utils::getSha512Hash($password), $expire, $path);
        setcookie(LOGIN_LEVEL, utils::getSha512Hash($accessLevel), $expire, $path);
    }
}