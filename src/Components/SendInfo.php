<?php


namespace ApiManager\Application\Components;


class SendInfo
{
    const GET_QUERY = 'get';
    const POST_FORM_DATA_QUERY = 'post-form-data';
    const POST_JSON_QUERY = 'post-json';

    /** @var string */
    protected $url;

    /** @var array */
    protected $getParams;

    /** @var array */
    protected $postParams;

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
     */
    public function __construct($typeQuery, $url, $response, $getParams = [], $postParams = [])
    {
        $this->typeQuery = $typeQuery;
        $this->setRequestInfo($url, $getParams, $postParams);
        $this->setResponseInfo($response);
    }

    /**
     * Установить значения данных запроса
     * @param string $url
     * @param array $getParams
     * @param array $postParams
     */
    protected function setRequestInfo($url, $getParams = [], $postParams = [])
    {
        $this->url = $url;
        $this->getParams = $getParams;
        $this->postParams = $postParams;
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
}