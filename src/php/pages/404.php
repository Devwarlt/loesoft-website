<?php
/**
 * Created by PhpStorm.
 * User: devwarlt
 * Date: 15/10/2019
 * Time: 12:29
 */

include "../utilities/Utils.php";
include "../handlers/IHandler.php";
include "../handlers/LoginHandler.php";

use php\utilities\Utils as utils;
use php\handlers\LoginHandler as login;

utils::getTemplateFromFile("Page not found!", "404", utils::htmlFormat, null, null, true, login::isLoggedIn());