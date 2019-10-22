<?php
/**
 * Created by PhpStorm.
 * User: devwarlt
 * Date: 15/10/2019
 * Time: 10:53
 */

namespace php\utilities\file_extension;


final class FileExtension implements IFileExtension
{
    private static $phpExtension;
    private static $htmlExtension;
    const phpFormat = ".php";
    const htmlFormat = ".html";

    private $format;

    public function __construct($format)
    {
        $this->format = $format;
    }

    /***
     * Gets a singleton-like instance of PHP **FileExtension** type.
     * @return FileExtension
     */
    public static function getPhpExtension()
    {
        if (self::$phpExtension === null)
            self::$phpExtension = new FileExtension(self::phpFormat);

        return self::$phpExtension;
    }

    /***
     * Gets a singleton-like instance of HTML **FileExtension** type.
     * @return FileExtension
     */
    public static function getHtmlExtension()
    {
        if (self::$htmlExtension === null)
            self::$htmlExtension = new FileExtension(self::htmlFormat);

        return self::$htmlExtension;
    }

    /***
     * Gets a file format extension as **string**.
     * @return string
     */
    public function getExtension()
    {
        return $this->format;
    }
}