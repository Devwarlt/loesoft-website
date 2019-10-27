<?php
/**
 * Created by PhpStorm.
 * User: devwarlt
 * Date: 16/10/2019
 * Time: 13:22
 */

namespace php\packet\handlers;

use php\packet\Debug;
use php\utilities\Utils as utils;
use php\utilities\DatabaseUtils as dbutils;
use php\packet\results\PacketResult as pr;
use php\packet\handlers\LoginHandler as login;

final class RegisterHandler extends Debug implements IHandler
{
    private static $singleton;

    public function __construct()
    {
        $this->configureDebug(false);
    }

    /**
     * Gets a singleton-like instance of class that implements **IHandler**.
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
     * @return string
     */
    public function handle(array $params)
    {
        $this->title("Register Handler");

        if (login::isLoggedIn()) {
            $this->debug("User is already logged in!");
            return pr::onInvalid();
        }

        $username = utils::tryGetValue($params, "username");
        $password = utils::tryGetValue($params, "password");

        if (utils::isNullOrEmpty($username) || utils::isNullOrEmpty($password)) {
            $this->debug("Credentials are empty!");
            return pr::onInvalid();
        }

        $dbu = dbutils::getSingleton();

        if (!$dbu->isUsernameExist($username)) {
            if ($dbu->registerAccount($username, $password))
                return pr::onSuccess();
            else {
                $this->debug("It wasn't possible to create a new account on database!");
                return pr::onInvalid();
            }
        } else $this->debug("Username already in use!");

        return pr::onError();
    }
}