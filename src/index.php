<?php
include "php/utilities/Utils.php";
include "php/handlers/IHandler.php";
include "php/handlers/LoginHandler.php";

use php\utilities\Utils as utils;
use php\utilities\FileExtension as fe;
use php\handlers\LoginHandler as login;

utils::getTemplateFromFile("Home", "home", fe::getHtmlExtension(), null, "home", false, login::isLoggedIn());