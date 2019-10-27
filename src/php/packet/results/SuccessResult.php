<?php
/**
 * Created by PhpStorm.
 * User: devwarlt
 * Date: 26/10/2019
 * Time: 14:42
 */

namespace php\packet\results;

use php\packet\results\PacketResult as pr;

final class SuccessResult implements IResult
{
    private static $singleton;
    private $result;

    public function __construct($result)
    {
        $this->result = $result;
    }

    /**
     * Gets a singleton-like instance of **SuccessResult** class.
     * @return SuccessResult
     */
    public static function getSingleton()
    {
        if (self::$singleton === null)
            self::$singleton = new SuccessResult(pr::success);

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