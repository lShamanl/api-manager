<?php
/**
 * Общий пример использования библиотеки. Отправка методом POST(json)
 */
require_once __DIR__ . '/api-manager/src/bootstrap.php';

use ApiManager\Application\ApiManager;
use ApiManager\Application\Classes\DataGuard;
use ApiManager\Application\Services\ApiService\Components\ApiAnswer;
use GuzzleHttp\Exception\GuzzleException;

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

    echo ApiAnswer::responseOk('Принято',ApiAnswer::CODE_202_ACCEPTED, true); exit;
} catch (Exception $e) {
    echo ApiAnswer::responseError($e,true); exit;
} catch (GuzzleException $e) {
    echo ApiAnswer::responseError($e,true); exit;
}