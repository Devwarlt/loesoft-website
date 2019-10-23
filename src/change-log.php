<?php
/**
 * Created by PhpStorm.
 * User: devwarlt
 * Date: 23/10/2019
 * Time: 19:24
 */

include "php/utilities/Utils.php";
include "php/handlers/IHandler.php";

use php\utilities\Utils as utils;
use php\utilities\FileExtension as fe;

utils::getTemplateFromFile("Change Log", "change-log", fe::getPhpExtension());