<?php
/**
 * Created by PhpStorm.
 * User: devwarlt
 * Date: 23/09/2019
 * Time: 15:12
 */

namespace php;

define("DB_HOST", "localhost");
define("DB_SCHEMA", "loesoft-devblog");
define("DB_USER", "root");
define("DB_PASSWORD", "");

class Database
{
    private static $singleton;
    private static $connection;
    private static $initialized = false;

    private function __construct(\PDO $connection)
    {
        self::$initialized = true;
        self::$connection = $connection;
    }

    public static function getSingleton()
    {
        if (!self::$initialized)
            self::$singleton = new Database(new \PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_SCHEMA, DB_USER, DB_PASSWORD));

        return self::$singleton;
    }

    public function update($sql, $params = null)
    {
        $this->insert($sql, $params);
    }

    public function insert($sql, $params = null)
    {
        $query = self::$connection->prepare($sql);

        if (!is_null($params))
            for ($i = 0; $i < count($params); $i++)
                $query->bindParam($i + 1, $params[$i]);

        $query->execute();
    }

    public function delete($sql, $params = null)
    {
        $this->insert($sql, $params);
    }

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