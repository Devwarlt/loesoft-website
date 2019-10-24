<?php
/**
 * Created by PhpStorm.
 * User: devwarlt
 * Date: 16/10/2019
 * Time: 12:34
 */

namespace php\handlers;

use php\utilities\DateUtils as dutils;
use php\utilities\DatabaseUtils as dbutils;
use php\utilities\Utils as utils;

define("LOGIN_USERNAME", "login-username-cookie");
define("LOGIN_PASSWORD", "login-password-cookie");

final class LoginHandler implements IHandler
{
    private static $singleton;

    /**
     * Gets a singleton-like instance of **LoginHandler** class.
     * @return LoginHandler
     */
    public static function getSingleton()
    {
        if (self::$singleton === null)
            self::$singleton = new LoginHandler();

        return self::$singleton;
    }

    /**
     * Handle a login message.
     * @param array $params
     * @return string
     */
    public function handle(array $params)
    {
        $debug = $params["debug"];
        $debug->autoTitle("[Login Handler]:");

        if (self::isLoggedIn()) {
            $debug->autoDebug("Already logged in.");
            return "invalid";
        }

        $username = utils::tryGetValue($params, "username");
        $password = utils::tryGetValue($params, "password");
        $dbu = dbutils::getSingleton();

        $debug->skip();

        if ($dbu->isAccountExist($username, $password, $debug)) {
            $debug->autoDebug("Account found!");
            $this->setLoginCookies($username, $password);
            return "true";
        }

        $debug->skip();
        $debug->autoDebug("Account not found!");
        return "false";
    }

    /**
     * Verify if user is already logged in.
     * @return bool
     */
    public static function isLoggedIn()
    {
        return array_key_exists(LOGIN_USERNAME, $_COOKIE) && array_key_exists(LOGIN_PASSWORD, $_COOKIE);
    }

    /**
     * Set current login session cookies.
     * @param $username
     * @param $password
     */
    private function setLoginCookies($username, $password)
    {
        $expire = dutils::getCurrentTimeAddition(dutils::hour);
        $path = "/";

        setcookie(LOGIN_USERNAME, $username, $expire, $path);
        setcookie(LOGIN_PASSWORD, utils::getSha512Hash($password), $expire, $path);
    }
}