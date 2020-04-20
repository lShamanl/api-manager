<?php


namespace lShamanl\ApiManager\Classes;

use lShamanl\ApiAnswer\StatusCode;
use lShamanl\ApiManager\Exceptions\InvalidDataException;

/**
 * Class DataGuard
 * @package lShamanl\ApiManager\Classes
 */
class DataGuard
{
    /**
     * @param array $params
     * @param bool $strict
     * @return void
     * @throws InvalidDataException
     */
    public static function required(array $params, $strict = true)
    {
        if ($strict) {
            self::strictGuard($params);
        } else {
            self::notStrictGuard($params);
        }
    }

    /**
     * @param array $params
     * @throws InvalidDataException
     */
    protected static function strictGuard(array $params)
    {
        foreach ($params as $key => $param) {
            if (empty($param)) {
                throw new InvalidDataException("Обязательное поле '{$key}' не было получено",StatusCode::HTTP_BAD_REQUEST);
            }
        }
    }

    /**
     * @param array $params
     * @throws InvalidDataException
     */
    protected static function notStrictGuard(array $params)
    {
        foreach ($params as $key => $param) {
            if (!isset($param)) {
                throw new InvalidDataException("Обязательное поле '{$key}' не было получено", StatusCode::HTTP_BAD_REQUEST);
            }
        }
    }
}