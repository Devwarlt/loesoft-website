<?php
/**
 * Created by PhpStorm.
 * User: devwarlt
 * Date: 15/10/2019
 * Time: 12:29
 */

include "../utilities/Utils.php";

use php\utilities\Utils as utils;
use php\utilities\FileExtension as fe;

utils::getTemplateFromFile("Page not found!", "404", fe::getHtmlExtension(), null, null, true);