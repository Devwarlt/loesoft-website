<?php
/**
 * Created by PhpStorm.
 * User: devwarlt
 * Date: 23/10/2019
 * Time: 11:20
 */

use php\handlers\PacketManager as pm;

$pm = pm::getSingleton();
echo $pm->handle($_POST);