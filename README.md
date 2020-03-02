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

    echo ApiAnswer::responseOk('Принято',ApiAnswer::CODE_202_ACCEPTED, true); exit;
} catch (Exception $e) {
    echo ApiAnswer::responseError($e,true); exit;
} catch (GuzzleException $e) {
    echo ApiAnswer::responseError($e,true); exit;
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

    echo ApiAnswer::responseOk('Принято',ApiAnswer::CODE_202_ACCEPTED, true); exit;
} catch (Exception $e) {
    echo ApiAnswer::responseError($e,true); exit;
} catch (GuzzleException $e) {
    echo ApiAnswer::responseError($e,true); exit;
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

    echo ApiAnswer::responseOk('Принято',ApiAnswer::CODE_202_ACCEPTED, true); exit;
} catch (Exception $e) {
    echo ApiAnswer::responseError($e,true); exit;
} catch (GuzzleException $e) {
    echo ApiAnswer::responseError($e,true); exit;
}
```
