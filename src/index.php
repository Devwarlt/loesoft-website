<?php
include "php/utilities/AutoLoader.php";

use php\utilities\AutoLoader as al;
use php\utilities\Utils as utils;
use php\packet\handlers\LoginHandler as login;

al::register();
utils::getTemplateFromFile("Home", "home", utils::htmlFormat, false, login::isLoggedIn());