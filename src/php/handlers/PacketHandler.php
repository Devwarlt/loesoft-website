<?php
/**
 * Created by PhpStorm.
 * User: devwarlt
 * Date: 16/10/2019
 * Time: 13:47
 */

namespace php\handlers;


// TODO: make a global packet handler algorithm that implements usage of jQuery scripts along post methods.
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

    public function handle(array $params)
    {
        // TODO: Implement handle() method.
    }
}