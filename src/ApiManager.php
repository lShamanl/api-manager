<?php


namespace lShamanl\ApiManager;

use lShamanl\ApiManager\Components\SendInfo;
use lShamanl\ApiManager\Exceptions\ApiManagerException;
use lShamanl\ApiManager\Services\ApiService\ApiService;
use Exception;
use GuzzleHttp\Exception\GuzzleException;

/**
 * Class ApiManager
 * @method SendInfo send($method, array $getParams, array $postParams)
 * @package lShamanl\ApiManager
 */
class ApiManager
{
    const GET_QUERY = 'query';
    const POST_FORM_DATA = 'form_params';
    const POST_JSON = 'json';

    /** @var ApiService */
    protected static $apiService;

    /** @var string */
    private $url;

    /** @var array */
    private $headers;

    /** @var array */
    private $getParams;

    /** @var array */
    private $postParams;

    /**
     * ApiManager constructor.
     * @param string $url
     * @throws Exception
     */
    public function __construct($url)
    {
        self::$apiService = (self::$apiService instanceof ApiService) ? self::$apiService : new ApiService();
        $this->setUrl($url);
    }

    /**
     * @param string $method
     * @param array $getParams
     * @param array $postParams
     * @return SendInfo
     * @throws GuzzleException
     * @throws ApiManagerException
     */
    public function __invoke($method = self::GET_QUERY, array $getParams = [], array $postParams = [])
    {
        $apiManagerClone = clone $this;

        if (!empty($getParams)) {
            $apiManagerClone->addGetParams($getParams);
        }
        if (!empty($postParams)) {
            $apiManagerClone->addPostParams($postParams);
        }

        switch ($method) {
            case self::GET_QUERY: return $apiManagerClone->sendGet();
            case self::POST_FORM_DATA: return $apiManagerClone->sendPostForm();
            case self::POST_JSON: return $apiManagerClone->sendPostJson();
        }

        throw new ApiManagerException('Не существующий метод');
    }

    /**
     * @param string $url
     * @return $this
     * @throws ApiManagerException
     */
    public function setUrl($url)
    {
        if (!filter_var($url, FILTER_VALIDATE_URL)) {
            throw new ApiManagerException("Кажется это '{$url}' - не является URL");
        }

        $this->url = $url;
        return $this;
    }

    /**
     * @param string $name
     * @param $arguments
     * @return SendInfo|null
     * @throws GuzzleException
     * @throws ApiManagerException
     */
    public function __call($name, $arguments)
    {
        if ($name === 'send') {
            return $this($arguments[0], $arguments[1], $arguments[2]);
        }

        return null;
    }

    /**
     * Добавляет GET-параметры к запросу
     * @param array $getParams
     * @return ApiManager
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
     * @return ApiManager
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
     * @return ApiManager
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

    /**
     * @param array|null $getParams
     * @return SendInfo
     * @throws GuzzleException
     */
    public function sendGet(array $getParams = null)
    {
        if (isset($getParams)) {
            $this->addGetParams($getParams);
        }

        $response = self::$apiService->sendGet($this->getUrl(), $this->getGetParams(), $this->getHeaders());

        return new SendInfo(self::GET_QUERY, $this->getUrl(), $response, $this->getGetParams());
    }

    /**
     * @param array|null $postParams
     * @return SendInfo
     * @throws GuzzleException
     */
    public function sendPostForm(array $postParams = null)
    {
        if (isset($postParams)) {
            $this->addPostParams($postParams);
        }

        $response = self::$apiService->sendPostForm($this->getUrl(), $this->getGetParams(), $this->getPostParams(), $this->getHeaders());
        return new SendInfo(self::POST_FORM_DATA, $this->getUrl(), $response, $this->getGetParams(), $this->getPostParams());
    }

    /**
     * @param array|null $postParams
     * @return SendInfo
     * @throws GuzzleException
     */
    public function sendPostJson(array $postParams = null)
    {
        if (isset($postParams)) {
            $this->setPostParams($postParams);
        }

        $response = self::$apiService->sendPostJson($this->getUrl(), $this->getGetParams(), $this->getPostParams(), $this->getHeaders());
        return new SendInfo(self::POST_JSON, $this->getUrl(), $response, $this->getGetParams(), $this->getPostParams());
    }

    /**
     * @return array
     */
    public function getHeaders()
    {
        return $this->headers;
    }
}