<?php


namespace lShamanl\ApiManager\Components;


class SendInfo
{

    /** @var string */
    protected $url;

    /** @var array */
    protected $getParams;

    /** @var array */
    protected $postParams;

    /** @var array */
    protected $headers;

    /** @var string */
    protected $response;

    /** @var string */
    protected $typeQuery;

    /**
     * SendInfo constructor.
     * @param string $typeQuery
     * @param string $url
     * @param string $response
     * @param array $getParams
     * @param array $postParams
     * @param array $headers
     */
    public function __construct($typeQuery, $url, $response, $getParams = [], $postParams = [], $headers = [])
    {
        $this->typeQuery = $typeQuery;
        $this->setRequestInfo($url, $getParams, $postParams, $headers);
        $this->setResponseInfo($response);
    }

    /**
     * Установить значения данных запроса
     * @param string $url
     * @param array $getParams
     * @param array $postParams
     * @param array $headers
     */
    protected function setRequestInfo($url, $getParams = [], $postParams = [], $headers = [])
    {
        $this->url = $url;
        $this->getParams = $getParams;
        $this->postParams = $postParams;
        $this->headers = $headers;
    }

    /**
     * Установить ответ от сервера
     * @param string $response
     */
    protected function setResponseInfo($response)
    {
        $this->response = $response;
    }

    /**
     * Возвращаем информацию в виде ассоциативного массива
     * @return array
     */
    public function toArray()
    {
        return [
            'typeQuery' => $this->typeQuery,
            'url' => $this->url,
            'getParams' => $this->getParams,
            'postParams' => $this->postParams,
            'headers' => $this->headers,
            'response' => $this->response,
        ];
    }

    /**
     * Возвращаем в виде строки
     * @return string|true
     */
    public function __toString()
    {
        return print_r($this->toArray(),true);
    }

    /**
     * @return string
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * @return array
     */
    public function getGetParams()
    {
        return $this->getParams;
    }

    /**
     * @return array
     */
    public function getPostParams()
    {
        return $this->postParams;
    }

    /**
     * @return string
     */
    public function getResponse()
    {
        return $this->response;
    }

    /**
     * @return string
     */
    public function getTypeQuery()
    {
        return $this->typeQuery;
    }

    /**
     * @return array
     */
    public function getHeaders()
    {
        return $this->headers;
    }
}