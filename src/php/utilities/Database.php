<?php
/**
 * Created by PhpStorm.
 * User: devwarlt
 * Date: 23/09/2019
 * Time: 15:12
 */

namespace php\utilities;

define("DB_HOST", "localhost");
define("DB_SCHEMA", "loesoft-devblog");
define("DB_USER", "root");
define("DB_PASSWORD", "");

/* SAMPLE CONNECTION:

require_once "php/Database.php";

use php\Database as db;

$db = db::getSingleton();
$result = $db->select("select * from accounts");

while ($row = $result->fetch(\PDO::FETCH_OBJ)) {
    echo "<br />"
        . "ID: " . $row->id . "<br />"
        . "Username: " . $row->username . "<br />"
        . "Password: " . $row->password . "<br />"
        . "Access Level: " . $row->access_level;
}*/

final class Database
{
    private static $singleton;
    private static $connection;

    /***
     * Database constructor.
     * @param \PDO $connection
     */
    private function __construct(\PDO $connection)
    {
        self::$connection = $connection;
    }

    /***
     * Gets the singleton-like instance of **Database**.
     * @return Database
     */
    public static function getSingleton()
    {
        if (!isset(self::$singleton))
            self::$singleton = new Database(new \PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_SCHEMA, DB_USER, DB_PASSWORD));

        return self::$singleton;
    }

    /***
     * Execute an update query on database.
     * @param $sql : SQL query.
     * @param null $params : (optional) extra parameters along $sql.
     */
    public function update($sql, $params = null)
    {
        $this->insert($sql, $params);
    }

    /***
     * Execute an insert query on database.
     * @param $sql : SQL query.
     * @param null $params : (optional) extra parameters along $sql.
     */
    public function insert($sql, $params = null)
    {
        $query = self::$connection->prepare($sql);

        if (!is_null($params))
            for ($i = 0; $i < count($params); $i++)
                $query->bindParam($i + 1, $params[$i]);

        $query->execute();
    }

    /***
     * Execute a delete query on database.
     * @param $sql : SQL query.
     * @param null $params : (optional) extra parameters along $sql.
     */
    public function delete($sql, $params = null)
    {
        $this->insert($sql, $params);
    }

    /***
     * Execute a select query on database and returns a **PDOStatement** to being used at fetch response.
     * @internal This method can result in invalidation in case of invalid query along execute (PDO).
     * @param $sql : SQL Query.
     * @param null $params : (optional) extra parameters along $sql.
     * @return null|\PDOStatement
     */
    public function select($sql, $params = null)
    {
        $query = self::$connection->query($sql);

        if (!is_null($params))
            for ($i = 0; $i < count($params); $i++)
                $query->bindParam($i + 1, $params[$i]);

        if ($query->execute() && $query->rowCount() > 0)
            return $query;

        return null;
    }
}