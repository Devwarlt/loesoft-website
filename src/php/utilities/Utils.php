<?php
/**
 * Created by PhpStorm.
 * User: devwarlt
 * Date: 07/10/2019
 * Time: 20:44
 */

namespace php\utilities;

final class Utils
{
    const phpFormat = ".php";
    const htmlFormat = ".html";

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
        "404" => "{404}",
        "login" => "{LOGIN}"
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
     * @param $loggedIn : (optional) replace **{LOGIN}** string key to current log-in definition.
     * @param null $script : (optional) javascript / jQuery script that will be embedded into page template.
     */
    public static function getTemplateFromFile($title, $contentPath, $extension, $css = null, $script = null, $is404 = false, $loggedIn = false)
    {
        $relativePath = "../assets/contents/$contentPath";
        $assetBundle = array(
            "template" => self::getContents("../template/page_body.html"),
            "title" => $title,
            "body" => $extension === self::htmlFormat ?
                self::getContents("$relativePath.html") :
                self::getPhpContents("$relativePath.php"),
            "footer" => self::getContents("../template/page_footer.html"),
            "css" => $css !== null ? self::getContents("../assets/stylesheets/$css.css", "style") : "",
            "script" => $script !== null ? self::getContents("../assets/scripts/$script.js", "script") : "",
            "404" => $is404 ? self::getRelativeLocationHref() : "unknown",
            "login" => $loggedIn ? "<a id=\"logout-option\" onclick=\"showOverlay('logout')\">Logout</a>" : "<a id=\"login-option\" onclick=\"showOverlay('login')\">Login</a>"
        );

        foreach (self::$DefaultStringsDictionary as $key => $value)
            $assetBundle["template"] = self::replace($key, $value, $assetBundle["template"]);

        foreach (self::$StringsDictionary as $key => $value)
            $assetBundle["template"] = self::replace($value, $assetBundle[$key], $assetBundle["template"]);

        echo $assetBundle["template"];
    }

    /***
     * Returns a string based on local path from folder **src/php**
     * @param $path : exist file from local resources.
     * @param null $tag : (optional) auto-format contents adding tags.
     * @return string
     */
    private static function getContents($path, $tag = null)
    {
        $file = dirname(__FILE__) . "/$path";

        if (!file_exists($file)) echo "<p style='color: red'><strong>File doesn't exist:</strong> " . dirname(__FILE__) . "/$path</p>";

        $result = file_get_contents($file);

        return $tag !== null ? "<" . $tag . ">" . $result . "</" . $tag . ">" : $result;
    }

    /***
     * Execute a PHP file on server-side.
     * @param $path
     * @return mixed
     */
    private static function getPhpContents($path)
    {
        $file = dirname(__FILE__) . "/$path";

        if (!file_exists($file)) echo "<p style='color: red'><strong>File doesn't exist:</strong> " . dirname(__FILE__) . "/$path</p>";

        return require($file);
    }

    /***
     * Returns a formatted string that contains relative location href requested by client.
     * @return string
     */
    private static function getRelativeLocationHref()
    {
        $location = @$_SERVER["HTTPS"] == "on" ? "https://" : "http://";

        if ($_SERVER["SERVER_PORT"] != "80")
            $location .= $_SERVER["SERVER_NAME"] . ":" . $_SERVER["SERVER_PORT"] . $_SERVER["REQUEST_URI"];
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
    public static function isNullOrEmpty($value)
    {
        return $value === null || empty($value);
    }

    /***
     * Try to get a value from dictionary based on key entry.
     * @param array $dictionary
     * @param $key
     * @return mixed|null
     */
    public static function tryGetValue(array $dictionary, $key)
    {
        if (count($dictionary) > 0)
            foreach ($dictionary as $innerKey => $innerValue) {
                echo $innerKey . "' equals '" . $key . "'' ? " . $innerKey === $key;

                if ($innerKey === $key)
                    return $innerValue;
            }

        return null;
    }

    /***
     * Replace full string params.
     * @param $value
     * @param array $array
     * @return string
     */
    public static function replaceArray($value, array $array)
    {
        foreach ($array as $innerKey => $innerValue)
            $value = self::replace($innerKey, $innerValue, $value);

        return $value;
    }
}