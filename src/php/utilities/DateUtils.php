<?php
/**
 * Created by PhpStorm.
 * User: devwarlt
 * Date: 16/10/2019
 * Time: 12:42
 */

namespace php\utilities;


final class DateUtils
{
    const second = 1;
    const minute = 1 * 60;
    const hour = 1 * 60 * 60;
    const day = 1 * 24 * 60 * 60;

    /***
     * Gets a current server time in seconds with additional second.
     * @param $seconds
     * @return int
     */
    public static function getCurrentTimeAddition($seconds)
    {
        return self::getCurrentTime() + $seconds;
    }

    /***
     * Gets a current server time in seconds.
     * @return int
     */
    public static function getCurrentTime()
    {
        return time();
    }
}