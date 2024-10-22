<?php
/**
 * Created by PhpStorm.
 * User: devwarlt
 * Date: 23/10/2019
 * Time: 19:24
 */

include "php/utilities/AutoLoader.php";

use php\utilities\AutoLoader as al;
use php\utilities\Utils as utils;
use php\packet\handlers\LoginHandler as login;

al::register();
utils::getTemplateFromFile("Change Log", "change-log", utils::phpFormat, false, login::isLoggedIn());