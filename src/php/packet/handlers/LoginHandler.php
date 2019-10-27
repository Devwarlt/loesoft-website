<?php
/**
 * Created by PhpStorm.
 * User: devwarlt
 * Date: 16/10/2019
 * Time: 12:34
 */

namespace php\packet\handlers;

use php\packet\results\PacketResult as pr;
use php\utilities\DateUtils as dutils;
use php\utilities\DatabaseUtils as dbutils;
use php\utilities\Utils as utils;

define("LOGIN_USERNAME", "login-username-cookie");
define("LOGIN_PASSWORD", "login-password-cookie");
define("LOGIN_ACCESS_LEVEL", "login-access-level-cookie");

final class LoginHandler implements IHandler
{
    private static $singleton;

    /**
     * Gets a singleton-like instance of class that implements **IHandler**.
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
        if (self::isLoggedIn()) return pr::onInvalid();

        $username = utils::tryGetValue($params, "username");
        $password = utils::tryGetValue($params, "password");

        if (utils::isNullOrEmpty($username) || utils::isNullOrEmpty($password))
            return pr::onInvalid();

        $dbu = dbutils::getSingleton();

        if ($dbu->isAccountExist($username, $password)) {
            $accessLevel = $dbu->getAccessLevelFromAccount($username, $password);
            $this->setLoginCookies($username, $password, $accessLevel);
            return pr::onSuccess();
        }

        return pr::onError();
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
     * @param $accessLevel
     */
    private function setLoginCookies($username, $password, $accessLevel)
    {
        $expire = dutils::getCurrentTimeAddition(dutils::hour);
        $path = "/";

        setcookie(LOGIN_USERNAME, $username, $expire, $path);
        setcookie(LOGIN_PASSWORD, utils::getSha512Hash($password), $expire, $path);
        setcookie(LOGIN_ACCESS_LEVEL, $accessLevel, $expire, $path);
    }
}