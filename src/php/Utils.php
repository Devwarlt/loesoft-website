<?php
/**
 * Created by PhpStorm.
 * User: devwarlt
 * Date: 07/10/2019
 * Time: 20:44
 */

namespace php;


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
        "script" => "{SCRIPT}"
    );

    /***
     * Echo a formatted file based in template and local file path.
     * @param $title : title of page.
     * @param $contentPath : exist file from local resources.
     * @param null $script : (optional) javascript / jQuery script that will be embedded into page.
     */
    public static function getTemplateFromFile($title, $contentPath, $script = null)
    {
        $assetBundle = array(
            "template" => self::getContents("template/page_body.html"),
            "title" => $title,
            "body" => self::getContents("assets/contents/$contentPath"),
            "footer" => self::getContents("template/page_footer.html"),
            "script" => !is_null($script) ? self::getContents("assets/scripts/$script") : ""
        );

        foreach (self::$StringsDictionary as $key => $value)
            $assetBundle["template"] = self::overrideTemplate($value, $assetBundle[$key], $assetBundle["template"]);

        echo $assetBundle;
    }

    // TODO: dynamic template generator from database.
    //public static function getTemplateFromDb($title, $postId, $script = null);

    /***
     * Returns a string based on local path from folder **src/php**
     * @param $path : exist file from local resources.
     * @return string
     */
    private static function getContents($path)
    {
        return file_get_contents(dirname(__FILE__ . "/$path"));
    }

    /***
     * Returns an overrided **string** replaced with values based on template.
     * @param $key
     * @param $value
     * @param $template
     * @return string
     */
    private static function overrideTemplate($key, $value, $template)
    {
        return str_replace($key, $value, $template);
    }
}