<?php
/**
 * Created by PhpStorm.
 * User: devwarlt
 * Date: 16/10/2019
 * Time: 13:47
 */

namespace php\handlers;

include "PacketId.php";
include "LoginHandler.php";
include "RegisterHandler.php";

use php\handlers\PacketId as pid;
use php\handlers\LoginHandler as login;
use php\handlers\RegisterHandler as register;

final class PacketHandler implements IHandler
{
    private static $singleton;

    /***
     * Gets a singleton-like instance of **PacketHandler** class.
     * @return PacketHandler
     */
    public static function getSingleton()
    {
        if (self::$singleton === null)
            self::$singleton = new PacketHandler();

        return self::$singleton;
    }

    /***
     * Handle all incoming packets from client-side (jQuery asynchronous integration).
     * @param array $params
     */
    public function handle(array $params)
    {
        if (!array_key_exists("id", $params))
            return;

        $id = $params["id"];

        switch ($id) {
            case pid::login: login::getSingleton()->handle($params); break;
            case pid::register: register::getSingleton()->handle($params); break;
            default: return;
        }
    }
}