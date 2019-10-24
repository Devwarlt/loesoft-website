<?php
/**
 * Created by PhpStorm.
 * User: devwarlt
 * Date: 16/10/2019
 * Time: 13:23
 */

namespace php\handlers;

interface IHandler
{
    public static function getSingleton();

    public function handle(array $params);
}