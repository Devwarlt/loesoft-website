<?php

namespace php\utilities;

use php\utilities\Database as db;
use php\utilities\Utils as utils;

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
     * @param $debug
     * @return bool
     */
    public function isAccountExist($username, $password, $debug)
    {
        $db = db::getSingleton();
        $action = array(
            "sql" => "select `id` from `accounts` where `username` = ':username' and `password` = ':password'",
            "params" => array(
                ":username" => $username,
                ":password" => utils::getSha512Hash($password)
            )
        );
        $action["sql"] = utils::replaceArray($action["sql"], $action["params"]);
        $result = $db->select($action["sql"]);
        $rows = $result->rowCount();

        $debug->autoDebug("SQL > " . $result->queryString);
        $debug->autoDebug("username > " . $action["params"][":username"] . " (" . $username . ")");
        $debug->autoDebug("password > " . $action["params"][":password"] . " (" . $password . ")");
        $debug->autoDebug("rows > " . $rows);

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
        $action = array(
            "sql" => "select `access_level` from `accounts` where `username` = ':username' and `password` = ':password'",
            "params" => array(
                ":username" => $username,
                ":password" => $password
            )
        );
        $action["sql"] = utils::replaceArray($action["sql"], $action["params"]);
        $result = $db->select($action["sql"]);

        if ($result->rowCount() == 0) return -1;

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
        $result = $db->select("select count(`id`) as `count` from `news`");

        if ($result === null) return 0;

        $query = $result->fetch(\PDO::FETCH_OBJ);

        return $query->count;
    }

    /***
     * Gets all news.
     * @param $page
     * @param $limit
     * @return \PDOStatement
     */
    public function getNewsByLimit($page, $limit)
    {
        $db = db::getSingleton();
        $action = array(
            "sql" => "select `id`, `creation`, `author_id`, `title`, `tags` from `news` limit :limit offset :offset",
            "params" => array(
                ":limit" => $limit,
                ":offset" => ($page - 1) * $limit
            )
        );
        $action["sql"] = utils::replaceArray($action["sql"], $action["params"]);
        $result = $db->select($action["sql"]);

        return $result;
    }

    /***
     * Gets news by id.
     * @param $id
     * @return \PDOStatement
     */
    public function getNewsContentById($id)
    {
        $db = db::getSingleton();
        $action = array(
            "sql" => "select * from `news` where `id` = :id",
            "params" => array(
                ":id" => $id
            )
        );
        $action["sql"] = utils::replaceArray($action["sql"], $action["params"]);
        $result = $db->select($action["sql"]);

        return $result;
    }

    /***
     * Count amount of change logs.
     * @return int|mixed
     */
    public function countChangeLogs()
    {
        $db = db::getSingleton();
        $result = $db->select("select count(`id`) as `count` from `changelogs`");

        if ($result === null) return 0;

        $query = $result->fetch(\PDO::FETCH_OBJ);

        return $query->count;
    }

    /***
     * Gets all change logs.
     * @param $page
     * @param $limit
     * @return \PDOStatement
     */
    public function getChangeLogsByLimit($page, $limit)
    {
        $db = db::getSingleton();
        $action = array(
            "sql" => "select * from `changelogs` limit :limit offset :offset",
            "params" => array(
                ":limit" => $limit,
                ":offset" => ($page - 1) * $limit
            )
        );
        $action["sql"] = utils::replaceArray($action["sql"], $action["params"]);
        $result = $db->select($action["sql"]);

        return $result;
    }
}