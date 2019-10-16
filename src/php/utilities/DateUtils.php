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
    private static $second = 1;
    private static $minute = 1 * 60;
    private static $hour = 1 * 60 * 60;
    private static $day = 1 * 24 * 60 * 60;

    /**
     * Gets a value that represents **1 second**.
     * @return int
     */
    public static function getSecond()
    {
        return self::$second;
    }

    /**
     * Gets a value that represents **1 minute**.
     * @return float|int
     */
    public static function getMinute()
    {
        return self::$minute;
    }

    /**
     * Gets a value that represents **1 hour**.
     * @return float|int
     */
    public static function getHour()
    {
        return self::$hour;
    }

    /**
     * Gets a value that represents **1 day**.
     * @return float|int
     */
    public static function getDay()
    {
        return self::$day;
    }

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