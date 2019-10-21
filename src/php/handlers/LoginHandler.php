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
inclide "../utilities/DatabaseUtils.php";

use php\utilities\DateUtils as dutils;
use php\utilities\Utils as utils;
use php\utilities\DatabaseUtils as dbutils;

define("LOGIN_USERNAME", "login-username-cookie");
define("LOGIN_PASSWORD", "login-password-cookie");


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
		$dbu = dbutils::getSingleton();
		
		if ($dbu->isAccountExist($username, $password))
			$this->setLoginCookies($username, $password);
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
     */
    private function setLoginCookies($username, $password, $accessLevel)
    {
        $expire = dutils::getCurrentTimeAddition(dutils::getHour());
        $path = "/";

        setcookie(LOGIN_USERNAME, $username, $expire, $path);
        setcookie(LOGIN_PASSWORD, $password, $expire, $path);
    }
}