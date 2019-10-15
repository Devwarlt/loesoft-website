<?php
/**
 * Created by PhpStorm.
 * User: devwarlt
 * Date: 15/10/2019
 * Time: 12:29
 */

require_once "../utilities/Utils.php";
require_once "../utilities/file_extension/FileExtension.php";

use php\utilities\Utils as utils;
use php\utilities\file_extension\FileExtension as fe;

utils::getTemplateFromFile("Page not found!", "404", fe::getHtmlExtension(), null, null, true);