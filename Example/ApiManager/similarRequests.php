<?php
/**
 * Общий пример использования библиотеки. Быстрая отправка похожих запросов
 */
require_once __DIR__ . '/src/bootstrap.php';

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

    echo new ApiAnswer(true, StatusCode::HTTP_OK,'Принято');
    http_response_code(StatusCode::HTTP_OK);
} catch (Exception $e) {
    echo new ApiAnswer(false, $e->getCode(), $e->getMessage());
    http_response_code($e->getCode());
} catch (GuzzleException $e) {
    echo new ApiAnswer(false, $e->getCode(), $e->getMessage());
    http_response_code($e->getCode());
}