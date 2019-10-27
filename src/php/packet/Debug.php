<?php
/**
 * Created by PhpStorm.
 * User: devwarlt
 * Date: 26/10/2019
 * Time: 16:20
 */

namespace php\packet;

abstract class Debug
{
    protected static $allEnabled = false;
    protected $enabled = false;

    /**
     * Display on log the title of instance.
     * @param $title
     */
    function title($title)
    {
        if ($this->isEnabled()) echo "<code class='code-title relative-center'><strong>--[ $title ]--</strong></code><br />";
    }

    /**
     * Verify if debug is enabled.
     * @return bool
     */
    public function isEnabled()
    {
        return self::$allEnabled && $this->enabled;
    }

    /**
     * Display on log the message.
     * @param $message
     */
    public function debug($message)
    {
        if ($this->isEnabled()) {
            echo "<code class='code-debug'>" . $message . "</code>";
            $this->jump();
        }
    }

    /**
     * Skip one line on log of messages.
     */
    public function jump()
    {
        if ($this->isEnabled()) echo "<br />";
    }

    /**
     * Skips one line and draw a line-break on log of messages.
     */
    public function skip()
    {
        if ($this->isEnabled()) echo "<hr />";
    }

    /**
     * Use this method to configure debug messages.
     * @param $enabled
     */
    function configureDebug($enabled)
    {
        $this->enabled = $enabled;
    }
}