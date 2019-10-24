<?php

use php\utilities\DatabaseUtils as dutils;

$page = 1;

if (array_key_exists("page", $_GET)) $page = $_GET["page"];

$limit = 20;

$dbu = dutils::getSingleton();
$count = $dbu->countChangeLogs();
$lastPage = floor($count / $limit);

if ($lastPage == 0) $lastPage = 1;
if ($page > $lastPage) $page = $lastPage;

$changeLogs = $dbu->getChangeLogsByLimit($page, $limit);
//$result = "<div>There is no change log published yet.</div>";

/*while ($changeLog = $changeLogs->fetch(PDO::FETCH_OBJ)) {
    $result .= "";
}*/

return $result;