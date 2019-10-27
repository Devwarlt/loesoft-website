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

final class Database
{
    private static $singleton;
    private static $connection;

    /**
     * Database constructor.
     * @param \PDO $connection
     */
    private function __construct(\PDO $connection)
    {
        self::$connection = $connection;
    }

    /**
     * Gets the singleton-like instance of **Database**.
     * @return Database
     */
    public static function getSingleton()
    {
        if (self::$singleton === null)
            self::$singleton = new Database(new \PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_SCHEMA, DB_USER, DB_PASSWORD));

        return self::$singleton;
    }

    /**
     * Execute an update query on database.
     * @param DatabaseQuery $query
     * @return bool
     */
    public function update(DatabaseQuery $query)
    {
        return $this->dml($query->getSql());
    }

    /**
     * **Data Manipulation Language**: INSERT, DELETE and UPDATE commands.
     * @param $sql
     * @return bool
     */
    private function dml($sql)
    {
        $query = self::$connection->prepare($sql);

        return $query->execute();
    }

    /**
     * Execute a delete query on database.
     * @param DatabaseQuery $query
     * @return bool
     */
    public function delete(DatabaseQuery $query)
    {
        return $this->dml($query->getSql());
    }

    /**
     * Execute an insert query on database.
     * @param DatabaseQuery $query
     * @return bool
     */
    public function insert(DatabaseQuery $query)
    {
        return $this->dml($query->getSql());
    }

    /**
     * Execute a select query on database and returns a **PDOStatement** to being used at fetch response.
     * @internal This method can result in invalidation in case of invalid query along execute (PDO).
     * @param DatabaseQuery $query
     * @return \PDOStatement
     */
    public function select(DatabaseQuery $query)
    {
        return $this->dql($query->getSql());
    }

    /**
     * **Data Query Language**: SELECT command.
     * @param $sql
     * @return \PDOStatement
     */
    private function dql($sql)
    {
        $query = self::$connection->query($sql);

        if ($query->execute() && $query->rowCount() > 0)
            return $query;

        return $query;
    }
}