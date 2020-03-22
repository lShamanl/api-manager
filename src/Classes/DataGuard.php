<?php


namespace lShamanl\ApiManager\Classes;

use lShamanl\ApiAnswer\StatusCode;
use lShamanl\ApiManager\Exceptions\InvalidDataException;


class DataGuard
{
    /**
     * @param array $params
     * @return void
     * @throws InvalidDataException
     */
    public static function required(array $params)
    {
        foreach ($params as $key => $param) {
            if (!isset($param)) {
                throw new InvalidDataException("Обязательное поле '{$key}' не было получено",StatusCode::HTTP_BAD_REQUEST);
            }
        }
    }
}