<?php


namespace ApiManager\Application;

use ApiManager\Application\Components\SendInfo;
use ApiManager\Application\Exceptions\MainAppException;
use ApiManager\Application\Services\ApiService\ApiService;
use Exception;
use GuzzleHttp\Exception\GuzzleException;

/**
 * Class ApiManager
 * @method SendInfo send($method, array $getParams, array $postParams)
 * @package ApiManager\Application
 */
class ApiManager
{
    const GET_QUERY = 'query';
    const POST_FORM_DATA = 'form_params';
    const POST_JSON = 'json';

    /** @var ApiService */
    protected $apiService;

    /**
     * ApiManager constructor.
     * @param string $url
     * @throws Exception
     */
    public function __construct($url)
    {
        $this->apiService = new ApiService();
        $this->apiService->setUrl($url);
    }

    /**
     * @param string $method
     * @param array $getParams
     * @param array $postParams
     * @return SendInfo
     * @throws GuzzleException
     * @throws MainAppException
     */
    public function __invoke($method = self::GET_QUERY, array $getParams = [], array $postParams = [])
    {
        $apiManagerClone = clone $this;

        if (!empty($getParams)) {
            $apiManagerClone->apiService->addGetParams($getParams);
        }
        if (!empty($postParams)) {
            $apiManagerClone->apiService->addPostParams($postParams);
        }

        switch ($method) {
            case self::GET_QUERY: return $apiManagerClone->sendGet();
            case self::POST_FORM_DATA: return $apiManagerClone->sendPostForm();
            case self::POST_JSON: return $apiManagerClone->sendPostJson();
        }

        throw new MainAppException('Не существующий метод');
    }

    /**
     * @param string $name
     * @param $arguments
     * @return SendInfo|null
     * @throws GuzzleException
     * @throws MainAppException
     */
    public function __call($name, $arguments)
    {
        if ($name === 'send') {
            return $this($arguments[0], $arguments[1], $arguments[2]);
        }

        return null;
    }

    /**
     * @param array $getParams
     * @return ApiManager
     */
    public function setGetParams(array $getParams)
    {
        $this->apiService->setGetParams($getParams);
        return $this;
    }

    /**
     * @param array $headers
     * @return ApiManager
     */
    public function setHeaders(array $headers)
    {
        $this->apiService->setHeaders($headers);
        return $this;
    }

    /**
     * @param array $getParams
     * @return ApiManager
     */
    public function addGetParams(array $getParams)
    {
        $this->apiService->addGetParams($getParams);
        return $this;
    }

    /**
     * @param array $headers
     * @return ApiManager
     */
    public function addHeaders(array $headers)
    {
        $this->apiService->addHeaders($headers);
        return $this;
    }

    /**
     * @param array $postParams
     * @return ApiManager
     */
    public function addPostParams(array $postParams)
    {
        $this->apiService->addPostParams($postParams);
        return $this;
    }

    /**
     * @param array $postParams
     * @return ApiManager
     */
    public function setPostParams(array $postParams)
    {
        $this->apiService->setPostParams($postParams);
        return $this;
    }

    /**
     * @param array|null $getParams
     * @return SendInfo
     * @throws GuzzleException
     */
    public function sendGet(array $getParams = null)
    {
        if (isset($getParams)) {
            $this->apiService->addGetParams($getParams);
        }

        $response = $this->apiService->sendGet();

        return new SendInfo(self::GET_QUERY, $this->apiService->getUrl(), $response, $this->apiService->getGetParams());
    }

    /**
     * @param array|null $postParams
     * @return SendInfo
     * @throws GuzzleException
     */
    public function sendPostForm(array $postParams = null)
    {
        if (isset($postParams)) {
            $this->apiService->addPostParams($postParams);
        }

        $response = $this->apiService->sendPost(false);

        return new SendInfo(self::POST_FORM_DATA, $this->apiService->getUrl(), $response, $this->apiService->getGetParams(), $this->apiService->getPostParams());
    }

    /**
     * @param array|null $postParams
     * @return SendInfo
     * @throws GuzzleException
     */
    public function sendPostJson(array $postParams = null)
    {
        if (isset($postParams)) {
            $this->apiService->setPostParams($postParams);
        }

        $response = $this->apiService->sendPost(true);
        return new SendInfo(self::POST_JSON, $this->apiService->getUrl(), $response, $this->apiService->getGetParams(), $this->apiService->getPostParams());
    }
}