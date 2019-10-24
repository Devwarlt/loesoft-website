<?php
/**
 * Created by PhpStorm.
 * User: devwarlt
 * Date: 16/10/2019
 * Time: 13:47
 */

namespace php\handlers;

use php\handlers\PacketId as pid;
use php\handlers\LoginHandler as login;
use php\handlers\RegisterHandler as register;
use php\utilities\Utils as utils;

final class PacketManager implements IHandler
{
    use Debuggable;

    private static $singleton;
    private $packets;

    public function __construct(array $packets)
    {
        $packets[pid::login] = login::getSingleton();
        $packets[pid::register] = register::getSingleton();
        $this->packets = $packets;
    }

    /**
     * Gets a singleton-like instance of **PacketManager** class.
     * @return PacketManager
     */
    public static function getSingleton()
    {
        if (self::$singleton === null)
            self::$singleton = new PacketManager(array());

        return self::$singleton;
    }

    /**
     * Handle all incoming packets from client-side (jQuery asynchronous integration).
     * @param array $params
     * @return null|mixed
     */
    public function handle(array $params)
    {
        $this->autoTitle("Server-side processing...");
        $this->autoDebug("Asynchronous fetch data response:");

        foreach ($params as $key => $value)
            $this->autoDebug("['<strong>" . $key . "</strong>']: " . (!utils::isNullOrEmpty($value) ? $value : "empty"));

        if (!array_key_exists("packetId", $params)) {
            $this->autoDebug("Packet ID doesn't contains in params!");

            return null;
        }

        $id = $params["packetId"];
        $params["debug"] = $this;
        $response = null;

        $this->skip();

        if (array_key_exists($id, $this->packets))
            $response = $this->packets[$id]->handle($params);
        else $this->autoDebug("Packet ID <strong>" . $params["packetId"] . "</strong> isn't implemented!");

        $this->skip();
        $this->autoDebug("<strong>Response</strong>:<br />" . (utils::isNullOrEmpty($response) ? $response : "empty"));
        $this->skip();
        $this->autoTitle("Client-side processing...");
        $this->autoDebug("<strong>Response</strong>:");

        return $response;
    }
}