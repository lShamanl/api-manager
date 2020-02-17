<?php


namespace ApiManager\Application\Classes;


class DataHelper
{
    /**
     * @return string
     * Возвращает случайную строку формата UUID
     */
    public static function generateUUID()
    {
        return sprintf('%04x%04x-%04x-%04x-%04x-%04x%04x%04x',
            // 32 bits for "time_low"
            mt_rand(0, 0xffff), mt_rand(0, 0xffff),

            // 16 bits for "time_mid"
            mt_rand(0, 0xffff),

            // 16 bits for "time_hi_and_version",
            // four most significant bits holds version number 4
            mt_rand(0, 0x0fff) | 0x4000,

            // 16 bits, 8 bits for "clk_seq_hi_res",
            // 8 bits for "clk_seq_low",
            // two most significant bits holds zero and one for variant DCE1.1
            mt_rand(0, 0x3fff) | 0x8000,

            // 48 bits for "node"
            mt_rand(0, 0xffff), mt_rand(0, 0xffff), mt_rand(0, 0xffff)
        );
    }

    /**
     * @return mixed
     * Возвращает ссылку, с которой был осуществлен переход на указанную страницу
     * (вызывать на индексной странице, и передавать через скрытое поле)
     */
    public static function getReferer()
    {
        return $_SERVER['HTTP_REFERER'];
    }

    /**
     * @return string
     * Возвращает IP сервера
     */
    public static function getServerIp()
    {
        return $_SERVER['SERVER_ADDR'];
    }

    /**
     * @return string
     * Возвращает IP пользователя
     */
    public static function getUserIp()
    {
        return $_SERVER['REMOTE_ADDR'];
    }

    /**
     * @return static
     * Возвращает домен сайта
     */
    public static function getDomain()
    {
        $parseUrl = DataHelper::getParseUrl();
        return $parseUrl['host'];
    }

    /**
     * @return array
     * Парсит URL и возвращает в виде массива отдельные его элементы
     */
    public static function getParseUrl()
    {
        $url = self::requestUrl();

        return parse_url($url);
    }

    /**
     * @return string
     * Возвращает текущий URL-адрес
     */
    public static function requestUrl()
    {
        if (isset($_SERVER['HTTPS']) && ($_SERVER['HTTPS'] == 'on')) {
            $protocol = 'https://';
            $defaultPort = 443;
        } else {
            $protocol = 'http://';
            $defaultPort = 80;
        }
        $port = ($_SERVER['SERVER_PORT'] != $defaultPort) ? ':' . $_SERVER['SERVER_PORT'] : '';

        return "{$protocol}{$_SERVER['SERVER_NAME']}{$port}{$_SERVER['REQUEST_URI']}";
    }
}