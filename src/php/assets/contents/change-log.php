<?php

use php\utilities\Utils as utils;
use php\utilities\DatabaseUtils as dutils;
use php\utilities\ChangeLog as cl;

$page = 1;

if (array_key_exists("page", $_GET)) $page = $_GET["page"];

$limit = 20;

$dbu = dutils::getSingleton();
$count = $dbu->countChangeLogs();
$lastPage = floor($count / $limit);

if ($lastPage == 0) $lastPage = 1;
if ($page > $lastPage) $page = $lastPage;

$result = "<div>There is no change log published yet.</div>";
$changeLogs = array(
    new cl(1, "1.0", cl::clientType, date("d/m/Y HH:i:s"), date("d/m/Y HH:i:s"), 1, 1, "This is a sample text."),
    new cl(2, "1.0", cl::serverType, date("d/m/Y HH:i:s"), date("d/m/Y HH:i:s"), 1, 1, "This is a sample text."),
    new cl(3, "1.0", cl::websiteType, date("d/m/Y HH:i:s"), date("d/m/Y HH:i:s"), 1, 1, "This is a sample text.")
);//$dbu->getChangeLogsByLimit($page, $limit);
$template = utils::getContents("../assets/contents/change-log-template.html");

if (count($changeLogs) > 0) {
    $result = "<table style='width: 100%;'><tbody>";

    foreach ($changeLogs as $changeLog)
        $result .= utils::replaceArray($template, array(
            "{ICON_TYPE}" => $changeLog->getType(),
            "{VERSION}" => $changeLog->getVersion(),
            "{TEXT}" => $changeLog->getContent(),
            "{AUTHOR}" => $changeLog->getAuthorId(),
            "{CREATION_DATE}" => $changeLog->getCreation(),
            "{DISPLAY}" => $changeLog->isChangeLogEdited() ? "block" : "none",
            "{EDITOR}" => $changeLog->getReviewerId(),
            "{EDITION_DATE}" => $changeLog->getEdited()
        ));

    $result .= "</tbody></table>";
}

/*while ($changeLog = $changeLogs->fetch(PDO::FETCH_OBJ)) {
    $result .= "";
}*/

return $result;