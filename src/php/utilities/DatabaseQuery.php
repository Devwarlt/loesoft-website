<?php
/**
 * Created by PhpStorm.
 * User: devwarlt
 * Date: 27/10/2019
 * Time: 16:33
 */

namespace php\utilities;

use php\utilities\Utils as utils;

final class DatabaseQuery
{
    private $sql;
    private $params;

    public function __construct($sql, array $params = null)
    {
        $this->sql = $sql;
        $this->params = $params;
    }

    /**
     * Gets SQL string formatted within params.
     * @return string
     */
    public function getSql()
    {
        if ($this->params !== null)
            $this->sql = utils::replaceArray($this->sql, $this->params);

        return $this->sql;
    }
}