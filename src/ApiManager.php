<?php


namespace ApiManager\Application;

use ApiManager\Application\Components\SendInfo;
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
     * @return SendInfo
     * @throws GuzzleException
     */
    public function sendGet(array $getParams = null)
    {
        if (isset($getParams)) {
            $this->apiService->addGetParams($getParams);
        }

        $response = $this->apiService->sendGet();

        return new SendInfo(SendInfo::GET_QUERY, $this->apiService->getUrl(), $response, $this->apiService->getGetParams());
    }

    /**
     * @param array|null $postParams
     * @return string
     * @throws GuzzleException
     */
    public function sendPostForm(array $postParams = null)
    {
        if (isset($postParams)) {
            $this->apiService->addPostParams($postParams);
        }

        $response = $this->apiService->sendPost(false);

        return new SendInfo(SendInfo::POST_FORM_DATA_QUERY, $this->apiService->getUrl(), $response, $this->apiService->getGetParams(), $this->apiService->getPostParams());
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

        $response = $this->apiService->sendPost(true);
        return new SendInfo(SendInfo::POST_JSON_QUERY, $this->apiService->getUrl(), $response, $this->apiService->getGetParams(), $this->apiService->getPostParams());
    }
}