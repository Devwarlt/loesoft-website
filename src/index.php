<?php
require_once "php/utilities/Utils.php";
require_once "php/utilities/file_extension/FileExtension.php";

use php\utilities\Utils as utils;
use php\utilities\file_extension\FileExtension as fe;

utils::getTemplateFromFile("Home", "home", fe::getHtmlExtension());