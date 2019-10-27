<?php

use php\utilities\Utils as utils;
use php\utilities\DatabaseUtils as dutils;
use php\utilities\ChangeLogEntry as cl;

$page = 1;

if (array_key_exists("page", $_GET)) $page = $_GET["page"];

$limit = 5;

$dbu = dutils::getSingleton();
$count = $dbu->countChangeLogs();
$lastPage = ceil($count / $limit);

if ($lastPage == 0) $lastPage = 1;
if ($page > $lastPage) $page = $lastPage;

$result = "<div>There is no change log published yet.</div>";
$changeLogs = $dbu->getChangeLogsByLimit($page, $limit);
$scope = utils::getContents("../assets/contents/change-log-scope.html");
$entry = utils::getContents("../assets/contents/change-log-entry.html");

if ($changeLogs->rowCount() > 0) {
    $result = "<div class='text-center' style='color: var(--ws-shade-color-5)'>";
    $result .= "<code class='code-title relative-center'>We have found <span>" . $count . "</span> change log entr" . ($count > 1 ? "ies" : "y") . ".</code><br /><br />";
    $navigation = "<div style='color: var(--ws-shade-color-4); word-break: break-all;'>";
    $navigation .= "<strong>Page $page of $lastPage</strong>:<br/><small>";

    for ($i = 1; $i <= $lastPage; $i++)
        if ($i == $page)
            $navigation .= "&nbsp;&nbsp;<strong>" . $i . "</strong>";
        else
            $navigation .= "&nbsp;&nbsp;<a href='" . utils::getRelativeLocationHref(false) . "/change-log" . ($i == 1 ? "" : "?page=" . $i) . "'>" . $i . "</a>";

    $navigation .= "</small></div>";
    $result .= $navigation;
    $result .= "</div><br/><table class='change-log-table' style='width: 100%;'><tbody>";

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
            "{ID}" => $cl->getId(),
            "{ICON_TYPE}" => $cl->getIconType(),
            "{TYPE}" => $cl->getType(),
            "{VERSION}" => $cl->getVersion(),
            "{TEXT}" => $cl->getContent(),
            "{AUTHOR}" => $dbu->getUsernameById($cl->getAuthorId()),
            "{CREATION_DATE}" => $cl->getCreation(),
            "{DISPLAY}" => $cl->isChangeLogEdited() ? "block" : "none",
            "{EDITOR}" => $dbu->getUsernameById($cl->getReviewerId()),
            "{EDITION_DATE}" => $cl->getEdited()
        ));
    }

    $result .= "</tbody></table><br /><br /><div class='text-center' style='color: var(--ws-shade-color-5)'>" . $navigation . "</div>";
}

return $scope . "<br />" . $result;