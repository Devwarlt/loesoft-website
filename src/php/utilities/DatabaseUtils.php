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

    public function registerAccount($username, $password)
    {
        $db = db::getSingleton();

        return $db->insert(new DatabaseQuery(
            "insert into `accounts` (`username`, `password`) values (':username', ':password')",
            [":username" => $username, ":password" => utils::getSha512Hash($password)]
        ));
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
        $result = $db->select(
            new DatabaseQuery(
                "select `id` from `accounts` where `username` = ':username' and `password` = ':password'",
                [":username" => $username, ":password" => $hasEncryption ? utils::getSha512Hash($password) : $password]
            ));

        return $result->rowCount() > 0;
    }

    /**
     * Check if username exists.
     * @param $username
     * @return bool
     */
    public function isUsernameExist($username)
    {
        $db = db::getSingleton();
        $result = $db->select(
            new DatabaseQuery(
                "select `username` from `accounts` where `username` = ':username'",
                [":username" => $username]
            ));

        return $result->rowCount() > 0;
    }

    /**
     * Gets username from accounts.
     * @param $id
     * @return string
     */
    public function getUsernameById($id)
    {
        $db = db::getSingleton();
        $result = $db->select(
            new DatabaseQuery(
                "select `username` from `accounts` where `id` = ':id'",
                [":id" => $id]
            ));

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
        $result = $db->select(
            new DatabaseQuery(
                "select `id` from `accounts` where `username` = ':username' and `password` = ':password'",
                [":username" => $username, ":password" => $hasEncryption ? utils::getSha512Hash($password) : $password]
            ));

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
        $result = $db->select(
            new DatabaseQuery(
                "select `access_level` from `accounts` where `username` = ':username' and `password` = ':password'",
                [":username" => $username, ":password" => $hasEncryption ? utils::getSha512Hash($password) : $password]
            ));

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
        $result = $db->select(new DatabaseQuery("select count(`id`) as `count` from `news`"));

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

        return $db->select(
            new DatabaseQuery(
                "select `id`, `creation`, `author_id`, `title`, `tags` from `news` limit :limit offset :offset",
                [":limit" => $limit, ":offset" => ($page - 1) * $limit]
            ));
    }

    /**
     * Gets news by id.
     * @param $id
     * @return \PDOStatement
     */
    public function getNewsContentById($id)
    {
        $db = db::getSingleton();

        return $db->select(
            new DatabaseQuery(
                "select * from `news` where `id` = :id",
                [":id" => $id]
            ));
    }

    /**
     * Count amount of change logs.
     * @return int|mixed
     */
    public function countChangeLogs()
    {
        $db = db::getSingleton();
        $result = $db->select(new DatabaseQuery("select count(`id`) as `count` from `changelogs`"));

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

        return $db->select(
            new DatabaseQuery(
                "select * from `changelogs` order by `id` desc limit :limit offset :offset",
                [":limit" => $limit, ":offset" => ($page - 1) * $limit]
            ));
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

        return $db->insert(
            new DatabaseQuery(
                "insert into `changelogs` (`version`, `type`, `author_id`, `content`) values (':version', :type, :author_id, ':content')",
                [":version" => $version, ":type" => $type, ":author_id" => $authorId, ":content" => $content]
            ));
    }

    /**
     * Update a change log entry.
     * @param $version
     * @param $type
     * @param $reviewerId
     * @param $content
     * @return bool
     */
    public function editChangeLog($id, $version, $type, $reviewerId, $content)
    {
        $db = db::getSingleton();

        return $db->update(
            new DatabaseQuery(
                "update `changelogs` set `version` = ':version', `type` = :type, `reviewer_id` = :reviewer_id, `content` = ':content', `edited` = CURRENT_TIMESTAMP where `id` = :id",
                [":id" => $id, ":version" => $version, ":type" => $type, ":reviewer_id" => $reviewerId, ":content" => $content]
            ));
    }

    /**
     * Delete a change log entry.
     * @param $id
     * @return bool
     */
    public function deleteChangeLog($id)
    {
        $db = db::getSingleton();

        return $db->delete(
            new DatabaseQuery(
                "delete from `changelogs` where `id` = :id",
                [":id" => $id]
            ));
    }
}