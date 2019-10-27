<?php
/**
 * Created by PhpStorm.
 * User: devwarlt
 * Date: 16/10/2019
 * Time: 13:23
 */

namespace php\packet\handlers;

interface IHandler
{
    /**
     * Gets a singleton-like instance of class that implements **IHandler**.
     * @return mixed
     */
    public static function getSingleton();

    /**
     * A method to handle all required processing tasks of class that implements **IHandler**.
     * @param array $params
     * @return mixed
     */
    public function handle(array $params);
}