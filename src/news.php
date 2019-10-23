<?php
/**
 * Created by PhpStorm.
 * User: devwarlt
 * Date: 23/10/2019
 * Time: 19:23
 */

include "php/utilities/Utils.php";
include "php/handlers/IHandler.php";
include "php/handlers/LoginHandler.php";

use php\utilities\Utils as utils;
use php\utilities\FileExtension as fe;
use php\handlers\LoginHandler as login;

utils::getTemplateFromFile("News", "news", fe::getPhpExtension(), null, null, false, login::isLoggedIn());