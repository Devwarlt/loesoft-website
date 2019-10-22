<?php

namespace php\utilities;

include "Database.php";
include "Utils.php";

use \php\utilities\Database as db;
use \php\utilities\Utils as utils;

final class DatabaseUtils
{
    private static $singleton;

    /***
     * Gets a singleton-like instance of **DatabaseUtils** class.
     * @return DatabaseUtils
     */
    public static function getSingleton()
    {
        if (self::$singleton === null)
            self::$singleton = new DatabaseUtils();

        return self::$singleton;
    }

    /***
     * Check if account exists.
     * @param $username
     * @param $password
     * @return bool
     */
    public function isAccountExist($username, $password)
    {
        $db = db::getSingleton();
        $result =
            $db->select("select `id` from `accounts` where `username` = ':username' and `password` = ':password'",
                array(
                    ":username" => utils::getSha512Hash($username),
                    ":password" => utils::getSha512Hash($password)
                ));

        return $result !== null && $result->rowCount() == 1;
    }

    /***
     * Gets account level from account credentials.
     * @param $username
     * @param $password
     * @return int
     */
    public function getAccessLevelFromAccount($username, $password)
    {
        $db = db::getSingleton();
        $result =
            $db->select("select `access_level` from `accounts` where `username` = ':username' and `password` = ':password'",
                array(
                    ":username" => $username,
                    ":password" => $password
                ));

        if ($result === null) return -1;

        $account = $result->fetch(\PDO::FETCH_OBJ);

        return $account->access_level;
    }

    /***
     * Count amount of news.
     * @return int|mixed
     */
    public function countNews()
    {
        $db = db::getSingleton();
        $result =
            $db->select("select count(`id`) as `count` from `news`");

        if ($result === null) return 0;

        $query = $result->fetch(\PDO::FETCH_OBJ);

        return $query->count;
    }

    /***
     * Gets all news.
     * @param $page
     * @param $limit
     * @return null|\PDOStatement
     */
    public function getNewsByLimit($page, $limit)
    {
        $db = db::getSingleton();
        $result =
            $db->select("select `id`, `creation`, `author_id`, `title`, `tags` from `news` limit :limit offset :offset",
                array(
                    ":limit" => $limit,
                    ":offset" => ($page - 1) * $limit
                ));

        return $result;
    }

    /***
     * Gets news by id.
     * @param $id
     * @return null|\PDOStatement
     */
    public function getNewsContentById($id)
    {
        $db = db::getSingleton();
        $result =
            $db->select("select * from `news` where `id` = :id",
                array(
                    ":id" => $id
                ));

        return $result;
    }

    /***
     * Count amount of change logs.
     * @return int|mixed
     */
    public function countChangeLogs()
    {
        $db = db::getSingleton();
        $result =
            $db->select("select count(`id`) as `count` from `changelogs`");

        if ($result === null) return 0;

        $query = $result->fetch(\PDO::FETCH_OBJ);

        return $query->count;
    }

    /***
     * Gets all change logs.
     * @param $page
     * @param $limit
     * @return null|\PDOStatement
     */
    public function getChangeLogsByLimit($page, $limit)
    {
        $db = db::getSingleton();
        $result =
            $db->select("select * from `changelogs` limit :limit offset :offset",
                array(
                    ":limit" => $limit,
                    ":offset" => ($page - 1) * $limit
                ));

        return $result;
    }
}