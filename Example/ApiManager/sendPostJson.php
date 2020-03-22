<?php
/**
 * Общий пример использования библиотеки. Отправка методом POST(json)
 */
require_once __DIR__ . '/api-manager/src/bootstrap.php';

use GuzzleHttp\Exception\GuzzleException;
use lShamanl\ApiAnswer\ApiAnswer;
use lShamanl\ApiAnswer\StatusCode;
use lShamanl\ApiManager\ApiManager;
use lShamanl\ApiManager\Classes\DataGuard;

try {
    DataGuard::required([
        'fio' => $_POST['fio'],
        'phone' => $_POST['phone'],
    ]);

    $answer = (new ApiManager('https://webhook.site/'))
        ->addGetParams([
            'getkey1' => 'value1'
        ])
        ->addPostParams([
            'postkey1' => 'value2'
        ])
        ->addHeaders([
            'my-header' => 'header_value'
        ])
        ->sendPostJson();

    echo new ApiAnswer(true, StatusCode::HTTP_OK,'Принято');
    http_response_code(StatusCode::HTTP_OK);
} catch (Exception $e) {
    echo new ApiAnswer(false, $e->getCode(), $e->getMessage());
    http_response_code($e->getCode());
} catch (GuzzleException $e) {
    echo new ApiAnswer(false, $e->getCode(), $e->getMessage());
    http_response_code($e->getCode());
}