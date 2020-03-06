<?php


namespace ApiManager\Application\Services\ApiService;


use ApiAnswer\Application\ApiAnswer;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Psr7\Uri;

class ApiService
{

    /** @var string */
    private $url;

    /** @var array */
    private $headers;

    /** @var array */
    private $getParams;

    /** @var array */
    private $postParams;

    /** @var Client */
    private $client;

    /**
     * ApiService constructor.
     */
    public function __construct()
    {
        $this->client = new Client();
    }

    /**
     * @param string $url
     * @param array $getParams
     * @param array $postParams
     * @return $this
     */
    public function setUrl($url, array $getParams = [], array $postParams = [])
    {
        $this->url = $url;
        $this->addGetParams($getParams);
        $this->addPostParams($postParams);

        return $this;
    }

    /**
     * Добавляет GET-параметры к запросу
     * @param array $getParams
     * @return ApiService
     */
    public function addGetParams(array $getParams)
    {
        if (!empty($getParams)) {
            foreach ($getParams as $key => $param) {
                if (!isset($param)) { continue; }
                $this->getParams[$key] = $param;
            }
        }

        return $this;
    }

    /**
     * Добавляет POST-параметры к запросу
     * @param array $postParams
     * @return $this
     */
    public function addPostParams(array $postParams)
    {
        if (!empty($postParams)) {
            foreach ($postParams as $key => $param) {
                if (!isset($param)) { continue; }
                $this->postParams[$key] = $param;
            }
        }

        return $this;
    }

    /**
     * Добавляет заголовки к запросу
     * @param array $headers
     * @return $this
     */
    public function addHeaders(array $headers)
    {
        if (!empty($headers)) {
            foreach ($headers as $key => $param) {
                if (!isset($param)) { continue; }
                $this->headers[$key] = $param;
            }
        }

        return $this;
    }

    /**
     * @param bool $inJson
     * @return string
     * $inJson - отправлять массив в формате json или form_data
     */
    public function sendPost($inJson)
    {
        $postMode = $inJson ? 'json' : 'form_params';

        $response = $this->client->request(
            'POST',
            new Uri($this->url),
            [
                $postMode => $this->postParams,
                'query' => $this->getParams,
                'headers' => $this->headers,
            ]
        );

        return $response->getBody()->getContents();
    }

    /**
     * @return string
     * @throws GuzzleException
     */
    public function sendGet()
    {
        $response = $this->client->request(
            'GET',
            new Uri($this->url),
            [
                'query' => $this->getParams,
                'headers' => $this->headers
            ]
        );

        return $response->getBody()->getContents();
    }

    /**
     * @return ApiAnswer
     * Сгенерировать шаблон ответа от API
     */
    public static function generateAnswer()
    {
        return new ApiAnswer();
    }

    /**
     * @param array $getParams
     */
    public function setGetParams(array $getParams)
    {
        $this->getParams = $getParams;
    }

    /**
     * @param array $postParams
     */
    public function setPostParams(array $postParams)
    {
        $this->postParams = $postParams;
    }

    /**
     * @return array
     */
    public function getPostParams()
    {
        return $this->postParams;
    }

    /**
     * @return array
     */
    public function getGetParams()
    {
        return $this->getParams;
    }

    /**
     * @return string
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * @param array $headers
     */
    public function setHeaders($headers)
    {
        $this->headers = $headers;
    }
}