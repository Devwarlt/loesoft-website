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
include "AccessLevel.php";
include "ChangeLogAction.php";
include "ChangeLogType.php";
include "PacketId.php";
include "Debug.php";
include "results/IResult.php";
include "results/ErrorResult.php";
include "results/InvalidResult.php";
include "results/SuccessResult.php";
include "results/PacketResult.php";
include "handlers/IHandler.php";
include "handlers/LoginHandler.php";
include "handlers/ChangeLogHandler.php";
include "handlers/RegisterHandler.php";
include "PacketManager.php";

use php\packet\PacketManager as pm;

if (count($_POST) == 0) {
    http_redirect("../../");
    return;
}

$pm = pm::getSingleton();
echo $pm->handle($_POST);