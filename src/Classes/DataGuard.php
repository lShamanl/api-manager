<?php


namespace ApiManager\Application\Classes;
use ApiAnswer\Application\ApiAnswer;
use ApiManager\Application\Exceptions\InvalidDataException;


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
                throw new InvalidDataException("Обязательное поле '{$key}' не было получено",ApiAnswer::CODE_400_BAD_REQUEST);
            }
        }
    }
}