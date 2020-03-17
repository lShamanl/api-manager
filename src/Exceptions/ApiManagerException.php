<?php
/**
 * Created by PhpStorm.
 * User: Shaman
 * Date: 25.03.2019
 * Time: 13:20
 */

namespace lShamanl\ApiManager\Exceptions;

use Exception;


/**
 * Class ApiManagerException
 * @package lShamanl\ApiManager\Exceptions
 * Это основной класс исключений, от которого нужно наследовать все остальные, используемые для данного приложения.
 */
class ApiManagerException extends Exception
{
    public function __construct($message, $code = 500, Exception $previous = null) {
        parent::__construct($message, $code, $previous);
    }

    public function __toString() {
        return __CLASS__ . ": [{$this->code}]: {$this->message}\n";
    }
}