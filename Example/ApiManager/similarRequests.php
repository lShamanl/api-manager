<?php
/**
 * Общий пример использования библиотеки. Быстрая отправка похожих запросов
 */
require_once __DIR__ . '/src/bootstrap.php';

use ApiAnswer\Application\ApiAnswer;
use ApiManager\Application\ApiManager;
use ApiManager\Application\Classes\DataGuard;

use GuzzleHttp\Exception\GuzzleException;

try {
    DataGuard::required([
        'fio' => $_POST['fio'],
        'phone' => $_POST['phone'],
    ]);

    $apiManager = (new ApiManager('https://webhook.site/'))
        ->addGetParams([
            'token' => '4uUVmWU7crP7YqKA'
        ])
        ->addPostParams([
            'comment' => 'Общий комментарий'
        ]);

    /** Отправка через магический метод send() */
    $a = $apiManager->send(ApiManager::POST_FORM_DATA, [], ['fio' => 'Имя 1', 'phone' => 16546846848]);
    $b = $apiManager(ApiManager::POST_FORM_DATA, [], ['fio' => 'Имя 33', 'phone' => 355413485]);

    echo ApiAnswer::responseOk('Принято', ApiAnswer::CODE_202_ACCEPTED, true);
    exit;
} catch (Exception $e) {
    echo ApiAnswer::responseError($e, true);
    exit;
} catch (GuzzleException $e) {
    echo ApiAnswer::responseError($e, true);
    exit;
}