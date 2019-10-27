<?php
/**
 * Created by PhpStorm.
 * User: devwarlt
 * Date: 26/10/2019
 * Time: 14:55
 */

namespace php\packet\results;

use php\packet\results\PacketResult as pr;

final class InvalidResult implements IResult
{
    private static $singleton;
    private $result;

    public function __construct($result)
    {
        $this->result = $result;
    }

    /**
     * Gets a singleton-like instance of **InvalidResult** class.
     * @return InvalidResult
     */
    public static function getSingleton()
    {
        if (self::$singleton === null)
            self::$singleton = new InvalidResult(pr::invalid);

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