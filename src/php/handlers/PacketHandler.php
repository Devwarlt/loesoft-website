<?php
/**
 * Created by PhpStorm.
 * User: devwarlt
 * Date: 23/10/2019
 * Time: 11:20
 */

include "../utilities/Utils.php";
include "../utilities/Database.php";
include "../utilities/DateUtils.php";
include "../utilities/DatabaseUtils.php";
include "IHandler.php";
include "Debuggable.php";
include "PacketId.php";
include "LoginHandler.php";
include "RegisterHandler.php";
include "PacketManager.php";

use php\handlers\PacketManager as pm;

$pm = pm::getSingleton();
echo $pm->handle($_POST);