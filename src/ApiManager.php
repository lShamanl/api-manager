<?php


namespace ApiManager\Application;

use ApiManager\Application\Services\ApiService\ApiService;
use Exception;
use GuzzleHttp\Exception\GuzzleException;


class ApiManager
{
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
     * @return string
     * @throws GuzzleException
     */
    public function sendGet(array $getParams = null)
    {
        if (isset($getParams)) {
            $this->apiService->setGetParams($getParams);
        }

        return $this->apiService->sendGet();
    }

    /**
     * @param array|null $postParams
     * @return string
     * @throws GuzzleException
     */
    public function sendPostForm(array $postParams = null)
    {
        if (isset($postParams)) {
            $this->apiService->setPostParams($postParams);
        }

        return $this->apiService->sendPost(false);
    }

    /**
     * @param array|null $postParams
     * @return string
     * @throws GuzzleException
     */
    public function sendPostJson(array $postParams = null)
    {
        if (isset($postParams)) {
            $this->apiService->setPostParams($postParams);
        }

        return $this->apiService->sendPost(true);
    }
}