<?php
/**
 * Created by PhpStorm.
 * User: devwarlt
 * Date: 26/10/2019
 * Time: 15:31
 */

namespace php\packet;

final class ChangeLogType
{
    const client = 0;
    const server = 1;
    const website = 2;
    public static $types = array(
        self::client,
        self::server,
        self::website
    );
}