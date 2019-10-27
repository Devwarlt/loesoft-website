<?php
/**
 * Created by PhpStorm.
 * User: devwarlt
 * Date: 16/10/2019
 * Time: 13:47
 */

namespace php\packet;

use php\packet\PacketId as pid;
use php\packet\handlers\IHandler;
use php\packet\handlers\ChangeLogHandler as changelog;
use php\packet\handlers\LoginHandler as login;
use php\packet\handlers\RegisterHandler as register;
use php\utilities\Utils as utils;

final class PacketManager extends Debug implements IHandler
{
    private static $singleton;
    private $packets;

    public function __construct(array $packets)
    {
        $packets[pid::login] = login::getSingleton();
        $packets[pid::register] = register::getSingleton();
        $packets[pid::changeLog] = changelog::getSingleton();
        $this->packets = $packets;
        $this->configureDebug(true);

        Debug::$allEnabled = true;
    }

    /**
     * Gets a singleton-like instance of class that implements **IHandler**.
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
        if ($this->isEnabled()) {
            $this->title("Packet Manager Handler");
            $this->debug("Fetching data from request:");
            $this->debug(utils::arrayToJSON($params));
            $this->jump();
        }

        if (!array_key_exists("packetId", $params)) {
            if ($this->isEnabled()) $this->debug("Packet ID doesn't contains in params!");
            return null;
        }

        $id = $params["packetId"];
        $response = null;

        if (array_key_exists($id, $this->packets)) {
            $packetSingleton = $this->packets[$id];

            if (is_subclass_of($packetSingleton, "Debug"))
                if ($packetSingleton->isEnabled())
                    $packetSingleton->skip();

            $response = $packetSingleton->handle($params);
        } else {
            if ($this->isEnabled())
                $this->debug("Packet ID <strong>" . $params["packetId"] . "</strong> isn't implemented!");
        }

        if ($this->isEnabled()) {
            $this->jump();
            $this->skip();
            $this->jump();
        }
        return $response;
    }
}