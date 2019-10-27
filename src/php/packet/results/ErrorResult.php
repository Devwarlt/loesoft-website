<?php
/**
 * Created by PhpStorm.
 * User: devwarlt
 * Date: 26/10/2019
 * Time: 14:54
 */

namespace php\packet\results;

use php\packet\results\PacketResult as pr;

final class ErrorResult implements IResult
{
    private static $singleton;
    private $result;

    public function __construct($result)
    {
        $this->result = $result;
    }

    /**
     * Gets a singleton-like instance of **ErrorResult** class.
     * @return ErrorResult
     */
    public static function getSingleton()
    {
        if (self::$singleton === null)
            self::$singleton = new ErrorResult(pr::error);

        return self::$singleton;
    }

    /**
     * Gets valid result for response.
     * @return string
     */
    public function result()
    {
        return $this->result;
    }
}