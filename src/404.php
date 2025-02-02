<?php
/**
 * Created by PhpStorm.
 * User: devwarlt
 * Date: 15/10/2019
 * Time: 12:29
 */

include "php/utilities/AutoLoader.php";

use php\utilities\AutoLoader as al;
use php\utilities\Utils as utils;
use php\packet\handlers\LoginHandler as login;

al::register();
utils::getTemplateFromFile("Page not found!", "404", utils::htmlFormat, true, login::isLoggedIn());