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
$changeLogs = $dbu->getChangeLogsByLimit($page, $limit);
$scope = utils::getContents("../assets/contents/change-log-scope.html");
$entry = utils::getContents("../assets/contents/change-log-entry.html");

if ($changeLogs->rowCount() > 0) {
    $result = "<table style='width: 100%;'><tbody>";

    while ($changeLog = $changeLogs->fetch(PDO::FETCH_OBJ)) {
        $cl = new cl(
            $changeLog->id,
            $changeLog->version,
            $changeLog->type,
            $changeLog->creation,
            $changeLog->edited,
            $changeLog->author_id,
            $changeLog->reviewer_id,
            $changeLog->content
        );
        $result .= utils::replaceArray($entry, array(
            "{ICON_TYPE}" => $cl->getType(),
            "{VERSION}" => $cl->getVersion(),
            "{TEXT}" => $cl->getContent(),
            "{AUTHOR}" => $cl->getAuthorId(),
            "{CREATION_DATE}" => $cl->getCreation(),
            "{DISPLAY}" => $cl->isChangeLogEdited() ? "block" : "none",
            "{EDITOR}" => $cl->getReviewerId(),
            "{EDITION_DATE}" => $cl->getEdited()
        ));
    }

    $result .= "</tbody></table>";
}

return $scope . "<br /><br />" . $result;