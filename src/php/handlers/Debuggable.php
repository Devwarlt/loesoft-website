<?php
/**
 * Created by PhpStorm.
 * User: devwarlt
 * Date: 23/10/2019
 * Time: 16:44
 */

namespace php\handlers;

trait Debuggable
{
    function skip()
    {
        if ($this->enabled()) echo "<hr />";
    }

    private function enabled()
    {
        return false;
    }

    function autoTitle($title)
    {
        if ($this->enabled()) echo "<strong>#$title</strong><br />";
    }

    function autoDebug($message)
    {
        if ($this->enabled()) echo "(DEBUG) " . $message . "<br />";
    }

    function title($enabled, $title)
    {
        if ($enabled) echo "<strong>#$title</strong><br />";
    }

    function debug($enabled, $message)
    {
        if ($enabled) echo "(DEBUG) " . $message . "<br />";
    }
}