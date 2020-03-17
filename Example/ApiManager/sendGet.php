<?php
/**
 * Общий пример использования библиотеки. Отправка методом GET
 */

require_once __DIR__ . '/api-manager/src/bootstrap.php';

use GuzzleHttp\Exception\GuzzleException;
use lShamanl\ApiAnswer\ApiAnswer;
use lShamanl\ApiManager\ApiManager;
use lShamanl\ApiManager\Classes\DataGuard;

try {
    DataGuard::required([
        'fio' => $_POST['fio'],
        'phone' => $_POST['phone'],
    ]);

    $answer = (new ApiManager('https://webhook.site/'))
        ->addGetParams([
            'key1' => 'value1'
        ])
        ->addHeaders([
            'my-header' => 'header_value'
        ])
        ->sendGet();

    echo ApiAnswer::responseOk('Принято', ApiAnswer::CODE_202_ACCEPTED, true); exit;
} catch (Exception $e) {
    echo ApiAnswer::responseError($e, true); exit;
} catch (GuzzleException $e) {
    echo ApiAnswer::responseError($e, true); exit;
}