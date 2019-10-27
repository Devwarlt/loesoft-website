<?php
/**
 * Created by PhpStorm.
 * User: devwarlt
 * Date: 26/10/2019
 * Time: 14:31
 */

namespace php\packet\results;

use php\packet\results\SuccessResult as success;
use php\packet\results\ErrorResult as error;
use php\packet\results\InvalidResult as invalid;

final class PacketResult
{
    const error = "false";
    const success = "true";
    const invalid = "invalid";

    /**
     * Format of "false" result.
     * @return string
     */
    public static function onError()
    {
        return error::getSingleton()->result();
    }

    /**
     * Format of "true" result.
     * @return string
     */
    public static function onSuccess()
    {
        return success::getSingleton()->result();
    }

    /**
     * Format of "invalid" result.
     * @return string
     */
    public static function onInvalid()
    {
        return invalid::getSingleton()->result();
    }
}