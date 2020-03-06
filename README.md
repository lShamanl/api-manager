# ApiManager
Библиотека для упрощения работы с API

### Установка:
```
composer require lshamanl/api-manager
```
   
### Желательно сделать:
Подключить перед выполнением скрипта следующий фрагмент кода:
```php
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
```
   
### Пример работы приложения:
Просто скопируйте один из готовых кейсов из папке "Example", положите его в папку с Вашим проектом и проверьте, что к нему подключен autoloader:

```php
require_once __DIR__ . '/api-manager/src/bootstrap.php';
```

#### Общий пример использования библиотеки

##### Отправка методом GET:
```php
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
```

##### Отправка методом POST(form_data):
```php
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
        ->sendPostForm();

    echo ApiAnswer::responseOk('Принято', ApiAnswer::CODE_202_ACCEPTED, true); exit;
} catch (Exception $e) {
    echo ApiAnswer::responseError($e, true); exit;
} catch (GuzzleException $e) {
    echo ApiAnswer::responseError($e, true); exit;
}
```

##### Отправка методом POST(json):
```php
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

    echo ApiAnswer::responseOk('Принято', ApiAnswer::CODE_202_ACCEPTED, true); exit;
} catch (Exception $e) {
    echo ApiAnswer::responseError($e, true); exit;
} catch (GuzzleException $e) {
    echo ApiAnswer::responseError($e, true); exit;
}
```

#### Быстрая отправка похожих запросов:
Вы можете подготовить запрос стандартным способом, а отправлять его при помощи магических методов, приведенных в примере:
```php
try {
    $apiManager = (new ApiManager('https://webhook.site/'))
        ->addGetParams([
            'token' => '4uUVmWU7crP7YqKA'
        ])
        ->addPostParams([
            'comment' => 'Общий комментарий'
        ]);

    /** Отправка через магический метод send() */
    $a = $apiManager->send(ApiManager::POST_FORM_DATA, ['get_param1' => 'get_value_1'], ['fio' => 'Имя 1', 'phone' => 16546846848]);

    /** Отправка через магический метод __invoke() */
    $b = $apiManager(ApiManager::POST_FORM_DATA, [], ['fio' => '2 Имя', 'phone' => 6544864484]);
    $c = $apiManager(ApiManager::POST_FORM_DATA, [], ['fio' => 'Имя 33', 'phone' => 355413485]);

    echo ApiAnswer::responseOk('Принято', ApiAnswer::CODE_202_ACCEPTED, true); exit;
} catch (Exception $e) {
    echo ApiAnswer::responseError($e, true); exit;
} catch (GuzzleException $e) {
    echo ApiAnswer::responseError($e, true); exit;
}
```
Отправка данных таким способом не модифицирует существующий объект ApiManager. Внутри этих магических методов происходит
клонирование текущего объекта, и все изменения касаются только клона, и никак не влияют на последующие запросы, которые
будут делаться на его основе. 

### Ответ от сервера
При обращении к серверу с помощью функций:
- ...->sendGet()
- ...->sendPostForm()
- ...->sendPostJson()

Возвращается объект класса "SendInfo", из которого можно получить следующую информацию:
```
Array
(
    [typeQuery] => ТИП_ОТПРАВКИ
    [url] => URL_НА_КОТОРЫЙ_ОСУЩЕСТВЛЯЛАСЬ_ОТПРАВКА
    [getParams] => МАССИВ_С_ПЕРЕДАННЫМИ_GET-ПАРАМЕТРАМИ
    [postParams] => МАССИВ_С_ПЕРЕДАННЫМИ_POST-ПАРАМЕТРАМИ
    [response] => ОТВЕТ_ОТ_СЕРВЕРА
)
```

### Другое:
https://github.com/lShamanl/api-answer - документация по ApiAnswer