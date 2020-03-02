<?php


use ApiAnswer\Application\ApiAnswer;

require_once __DIR__ . '/../vendor/autoload.php';


try {
    header('Content-Type: text/html; charset=utf-8');

    $rawData = file_get_contents('php://input');
    if (!empty($rawData)) {
        $_POST['_raw'] = $rawData;
    }

    if (!function_exists('curl_reset')) {
        function curl_reset(&$ch)
        {
            curl_close($ch);
            $ch = curl_init();
        }
    }
} catch (Exception $e) {
    ApiAnswer::responseError($e);
}
