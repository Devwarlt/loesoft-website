<?php
/**
 * Created by PhpStorm.
 * User: devwarlt
 * Date: 26/10/2019
 * Time: 14:35
 */

namespace php\packet\results;

interface IResult
{
    public static function getSingleton();

    public function __construct($result);

    public function result();
}