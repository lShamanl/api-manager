<?php


namespace lShamanl\ApiManager\Services\ApiService;


use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Uri;

class ApiService
{

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
     * @param array $headers
     * @return string
     */
    public function sendGet($url, $getParams = [], $headers = [])
    {
        $response = $this->client->request(
            'GET',
            new Uri($url),
            [
                'query' => $getParams,
                'headers' => $headers
            ]
        );

        return $response->getBody()->getContents();
    }

    /**
     * @param string $url
     * @param array $getParams
     * @param array $postParams
     * @param array $headers
     * @return string
     */
    public function sendPostForm($url, $getParams = [], $postParams = [], $headers = [])
    {
        $response = $this->client->request(
            'POST',
            new Uri($url),
            [
                'form_params' => $postParams,
                'query' => $getParams,
                'headers' => $headers,
            ]
        );

        return $response->getBody()->getContents();
    }

    /**
     * @param string $url
     * @param array $getParams
     * @param array $postParams
     * @param array $headers
     * @return string
     */
    public function sendPostJson($url, $getParams = [], $postParams = [], $headers = [])
    {
        $response = $this->client->request(
            'POST',
            new Uri($url),
            [
                'json' => $postParams,
                'query' => $getParams,
                'headers' => $headers,
            ]
        );

        return $response->getBody()->getContents();
    }

}