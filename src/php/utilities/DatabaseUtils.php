<?php

namespace php\utilities;

use php\packet\AccessLevel as al;
use php\utilities\Database as db;
use php\utilities\Utils as utils;

final class DatabaseUtils
{
    private static $singleton;

    /**
     * Gets a singleton-like instance of **DatabaseUtils** class.
     * @return DatabaseUtils
     */
    public static function getSingleton()
    {
        if (self::$singleton === null)
            self::$singleton = new DatabaseUtils();

        return self::$singleton;
    }

    /**
     * Check if account exists.
     * @param $username
     * @param $password
     * @param $hasEncryption
     * @return bool
     */
    public function isAccountExist($username, $password, $hasEncryption = true)
    {
        $db = db::getSingleton();
        $action = array(
            "sql" => "select `id` from `accounts` where `username` = ':username' and `password` = ':password'",
            "params" => array(
                ":username" => $username,
                ":password" => $hasEncryption ? utils::getSha512Hash($password) : $password
            )
        );
        $action["sql"] = utils::replaceArray($action["sql"], $action["params"]);
        $result = $db->select($action["sql"]);

        return $result !== null && $result->rowCount() == 1;
    }

    /**
     * Gets username from accounts.
     * @param $id
     * @return string
     */
    public function getUsernameById($id)
    {
        $db = db::getSingleton();
        $action = array(
            "sql" => "select `username` from `accounts` where `id` = ':id'",
            "params" => array(
                ":id" => $id
            )
        );
        $action["sql"] = utils::replaceArray($action["sql"], $action["params"]);
        $result = $db->select($action["sql"]);

        if ($result->rowCount() == 0) return "Unknown";

        $account = $result->fetch(\PDO::FETCH_OBJ);

        return $account->username;
    }

    /**
     * Gets id from account credentials.
     * @param $username
     * @param $password
     * @param $hasEncryption
     * @return int
     */
    public function getIdFromAccount($username, $password, $hasEncryption = true)
    {
        $db = db::getSingleton();
        $action = array(
            "sql" => "select `id` from `accounts` where `username` = ':username' and `password` = ':password'",
            "params" => array(
                ":username" => $username,
                ":password" => $hasEncryption ? utils::getSha512Hash($password) : $password
            )
        );
        $action["sql"] = utils::replaceArray($action["sql"], $action["params"]);
        $result = $db->select($action["sql"]);

        if ($result->rowCount() == 0) return -1;

        $account = $result->fetch(\PDO::FETCH_OBJ);

        return $account->id;
    }

    /**
     * Gets level from account credentials.
     * @param $username
     * @param $password
     * @param $hasEncryption
     * @return int
     */
    public function getAccessLevelFromAccount($username, $password, $hasEncryption = true)
    {
        $db = db::getSingleton();
        $action = array(
            "sql" => "select `access_level` from `accounts` where `username` = ':username' and `password` = ':password'",
            "params" => array(
                ":username" => $username,
                ":password" => $hasEncryption ? utils::getSha512Hash($password) : $password
            )
        );
        $action["sql"] = utils::replaceArray($action["sql"], $action["params"]);
        $result = $db->select($action["sql"]);

        if ($result->rowCount() == 0) return al::regular;

        $account = $result->fetch(\PDO::FETCH_OBJ);

        return $account->access_level;
    }

    /**
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

    /**
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

    /**
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

    /**
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

    /**
     * Gets all change logs.
     * @param $page
     * @param $limit
     * @return \PDOStatement
     */
    public function getChangeLogsByLimit($page, $limit)
    {
        $db = db::getSingleton();
        $action = array(
            "sql" => "select * from `changelogs` order by `id` desc limit :limit offset :offset",
            "params" => array(
                ":limit" => $limit,
                ":offset" => ($page - 1) * $limit
            )
        );
        $action["sql"] = utils::replaceArray($action["sql"], $action["params"]);
        $result = $db->select($action["sql"]);

        return $result;
    }

    /**
     * Adds new change log entry.
     * @param $version
     * @param $type
     * @param $authorId
     * @param $content
     * @return bool
     */
    public function publishChangeLog($version, $type, $authorId, $content)
    {
        $db = db::getSingleton();
        $action = array(
            "sql" => "insert into `changelogs` (`version`, `type`, `author_id`, `content`) values (':version', :type, :author_id, ':content')",
            "params" => array(
                ":version" => $version,
                ":type" => $type,
                ":author_id" => $authorId,
                ":content" => $content
            )
        );
        $action["sql"] = utils::replaceArray($action["sql"], $action["params"]);

        return $db->insert($action["sql"]);
    }
}