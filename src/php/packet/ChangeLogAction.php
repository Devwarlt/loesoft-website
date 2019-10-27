<?php
/**
 * Created by PhpStorm.
 * User: devwarlt
 * Date: 25/10/2019
 * Time: 22:31
 */

namespace php\packet;

final class ChangeLogAction
{
    const publish = 1;
    const edit = 2;
    const delete = 3;
    public static $actions = array(
        self::publish,
        self::edit,
        self::delete
    );
}