<?php
/**
 * Created by PhpStorm.
 * User: devwarlt
 * Date: 07/10/2019
 * Time: 20:44
 */

namespace php\utilities;

include "file_extension/IFileExtension.php";

use \php\utilities\file_extension\IFileExtension;

final class Utils
{
    /***
     * Contains a collection of keys used in file templates.
     * @var array
     */
    private static $StringsDictionary = array(
        "title" => "{TITLE}",
        "body" => "{BODY}",
        "footer" => "{FOOTER}",
        "css" => "{CSS}",
        "script" => "{SCRIPT}",
        "404" => "{404}"
    );

    /***
     * Contains a collect of default keys used in file templates.
     * @var array
     */
    private static $DefaultStringsDictionary = array(
        "{KEYWORDS}" => "loesoft, loesoft games, loe realm, loe, mmorpg, games",
        "{OG_URL}" => "http://localhost:1000/",
        "{OG_SITE_NAME}" => "LoESoft Games - DevBlog",
        "{OG_TITLE}" => "LoESoft Games",
        "{OG_DESCRIPTION}" => "Welcome to the LoESoft Games official developer blog! Here you'll find all change-logs, patch notes
    and related documentations about our side projects.",
        "{OG_IMAGE}" => "http://localhost:1000/media/favicon.png",
        "{OG_IMAGE_TYPE}" => "image/png",
        "{OG_IMAGE_WIDTH}" => "148",
        "{OG_IMAGE_HEIGHT}" => "148"
    );

    /***
     * Echo a formatted file based in template and local file path.
     * @param $title : title of page.
     * @param $contentPath : exist file from local resources.
     * @param $extension : file extension.
     * @param null $css : (optional) css that will be embedded into page template.
     * @param $is404 : (optional) replace **{PAGE}** string key to current targeted page.
     * @param null $script : (optional) javascript / jQuery script that will be embedded into page template.
     */
    public static function getTemplateFromFile($title, $contentPath, IFileExtension $extension, $css = null, $script = null, $is404 = false)
    {
        $assetBundle = array(
            "template" => self::getContents("../template/page_body.html"),
            "title" => $title,
            "body" => self::getContents("../assets/contents/$contentPath" . $extension->getExtension()),
            "footer" => self::getContents("../template/page_footer.html"),
            "css" => !is_null($css) ? self::getContents("../assets/stylesheets/$css.css", "style") : "",
            "script" => !is_null($script) ? self::getContents("../assets/scripts/$script.js", "script") : "",
            "404" => $is404 ? self::getRelativeLocationHref() : "unknown"
        );

        foreach (self::$DefaultStringsDictionary as $key => $value)
            $assetBundle["template"] = self::replace($key, $value, $assetBundle["template"]);

        foreach (self::$StringsDictionary as $key => $value)
            $assetBundle["template"] = self::replace($value, $assetBundle[$key], $assetBundle["template"]);

        echo $assetBundle["template"];
    }

    // TODO: dynamic template generator from database.
    //public static function getTemplateFromDb($title, $postId, $script = null);

    /***
     * Returns a string based on local path from folder **src/php**
     * @param $path : exist file from local resources.
     * @param null $tag : (optional) auto-format contents adding tags.
     * @return string
     */
    private static function getContents($path, $tag = null)
    {
        $result = null;
        $file = dirname(__FILE__) . "/$path";

        if (!file_exists($file)) echo "<p style='color: red'><strong>File doesn't exist:</strong> " . dirname(__FILE__) . "/$path</p>";

        $result = file_get_contents($file);

        return !is_null($tag) ? "<" . $tag . ">" . $result . "</" . $tag . ">" : $result;
    }

    /***
     * Returns a formatted string that contains relative location href requested by client.
     * @return string
     */
    private static function getRelativeLocationHref()
    {
        $location = @$_SERVER["HTTPS"] == "on" ? "https://" : "http://";

        if ($_SERVER["SERVER_PORT"] != "80") $location .= $_SERVER["SERVER_NAME"] . ":" . $_SERVER["SERVER_PORT"] . $_SERVER["REQUEST_URI"];
        else $location .= $_SERVER["SERVER_NAME"] . $_SERVER["REQUEST_URI"];

        return $location;
    }

    /***
     * Returns an overridden **string** replaced with values based on template.
     * @param $key
     * @param $value
     * @param $template
     * @return string
     */
    private static function replace($key, $value, $template)
    {
        return str_replace($key, $value, $template);
    }

    /***
     * Gets a hash value from SHA512 algorithm.
     * @param $value
     * @return string
     */
    public static function getSha512Hash($value)
    {
        return hash('sha512', $value);
    }

    /***
     * Verify if string is null or empty.
     * @param $value
     * @return bool
     */
    public static function IsNullOrEmptyString($value)
    {
        return !isset($value) || trim($value) === '';
    }
}