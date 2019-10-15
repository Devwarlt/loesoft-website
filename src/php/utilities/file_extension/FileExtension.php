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
    private static $PhpExtension;
    private static $HtmlExtension;
    private static $PhpFormat = ".php";
    private static $HtmlFormat = ".html";

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
        if (!isset(self::$PhpExtension))
            self::$PhpExtension = new FileExtension(self::$PhpFormat);

        return self::$PhpExtension;
    }

    /***
     * Gets a singleton-like instance of HTML **FileExtension** type.
     * @return FileExtension
     */
    public static function getHtmlExtension()
    {
        if (!isset(self::$HtmlExtension))
            self::$HtmlExtension = new FileExtension(self::$HtmlFormat);

        return self::$HtmlExtension;
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