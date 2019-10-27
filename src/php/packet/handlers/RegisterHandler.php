<?php
/**
 * Created by PhpStorm.
 * User: devwarlt
 * Date: 16/10/2019
 * Time: 13:22
 */

namespace php\packet\handlers;

final class RegisterHandler implements IHandler
{
    private static $singleton;

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
     * @return mixed
     */
    public function handle(array $params)
    {
        // TODO: implements this method.
    }
}