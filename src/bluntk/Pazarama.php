<?php
/**
 * Author: Kıvanç Ağaoğlu
 * Web: https://kivancagaoglu.com
 * Mail: info@kivancagaoglu.com
 * Skype: kivancagaoglu
 * Github: https://github.com/kivancagaogluu/
 *
 */


namespace bluntk;

use bluntk\Cache\Cache;
use GuzzleHttp\Exception\GuzzleException;

class Pazarama
{

    const API_URL = 'https://isortagimapi.pazarama.com/';

    const AUTH_URL = 'https://isortagimgiris.pazarama.com/connect/token';

    private $apiKey;

    private $apiSecret;

    public $client;

    /**
     * @param $config
     */
    public function __construct($config)
    {
        $this->apiKey = $config['api_key'];
        $this->apiSecret = $config['api_secret'];
        $this->client = new \GuzzleHttp\Client();
    }

    /**
     * @return false|mixed
     * @throws GuzzleException
     * @throws \Exception
     */
    public function getAuthToken()
    {
        if(Cache::exists($this->apiKey) and !Cache::expired($this->apiKey, 3600)){
            return Cache::get($this->apiKey);
        }
        $response = $this->client->request('POST', self::AUTH_URL, [
            'form_params' => [
                'grant_type' => 'client_credentials',
                'scope' => 'merchantgatewayapi.fullaccess'
            ],
            'auth' => [
                $this->apiKey,
                $this->apiSecret
            ]
        ]);
        $data = json_decode($response->getBody()->getContents());
        if($data->success !== true){
            throw new \Exception('Auth Error');
        }
        Cache::set($this->apiKey, $data);
        return $data;
    }

    /**
     * @param $page
     * @param $size
     * @return mixed
     * @throws GuzzleException
     */
    public function brands($page = 1, $size = 10)
    {
        $response = $this->client->request('GET', self::API_URL . 'brand/getBrands', [
            'query' => [
                'page' => $page,
                'size' => $size
            ]
        ]);
        return json_decode($response->getBody()->getContents());
    }

    /**
     * @return mixed
     * @throws GuzzleException
     */
    public function categories()
    {
        $response = $this->client->request('GET', self::API_URL . 'category/getCategoryTree', [

        ]);
        return json_decode($response->getBody()->getContents());
    }

    /**
     * @param $id
     * @return mixed
     * @throws GuzzleException
     */
    public function categoryWithAttributes($id)
    {
        $response = $this->client->request('GET', self::API_URL . 'category/getCategoryWithAttributes', [
            'query' => [
                'Id' => $id
            ]
        ]);
        return json_decode($response->getBody()->getContents());
    }

    /**
     * @return mixed
     * @throws GuzzleException
     */
    public function sellerDeliveries()
    {
        $response = $this->client->request('GET', self::API_URL . 'sellerRegister/getSellerDelivery', [
            'headers' => [
                'Authorization' => 'Bearer ' . $this->getAuthToken()->data->accessToken
            ]
        ]);
        return json_decode($response->getBody()->getContents());
    }

    /**
     * @return mixed
     * @throws GuzzleException
     */
    public function cities()
    {
        $response = $this->client->request('GET', self::API_URL . 'parameter/cities', [

        ]);
        return json_decode($response->getBody()->getContents());
    }

    /**
     * @param $data
     * @return mixed
     * @throws GuzzleException
     */
    public function createProduct($data)
    {
        $response = $this->client->request('POST', self::API_URL . 'product/create', [
            'form_params' => $data,
            'headers' => [
                'Authorization' => 'Bearer ' . $this->getAuthToken()->data->accessToken
            ]
        ]);
        return json_decode($response->getBody()->getContents());
    }

    /**
     * @param $batchRequestId
     * @return mixed
     * @throws GuzzleException
     */
    public function productBatchRequest($batchRequestId)
    {
        $response = $this->client->request('POST', self::API_URL . 'product/getProductBatchResult', [
            'query' => [
                'BatchRequestId' => $batchRequestId
            ],
            'headers' => [
                'Authorization' => 'Bearer ' . $this->getAuthToken()->data->accessToken
            ]
        ]);
        return json_decode($response->getBody()->getContents());
    }

    /**
     * @param $data
     * @return mixed
     * @throws GuzzleException
     */
    public function updatePrice($data)
    {
        $response = $this->client->request('POST', self::API_URL . 'product/updatePrice', [
            'form_params' => $data,
            'headers' => [
                'Authorization' => 'Bearer ' . $this->getAuthToken()->data->accessToken
            ]
        ]);
        return json_decode($response->getBody()->getContents());
    }

    /**
     * @param $data
     * @return mixed
     * @throws GuzzleException
     */
    public function updateStock($data)
    {
        //send request from client
        $response = $this->client->request('POST', self::API_URL . 'product/updateStock', [
            'form_params' => $data,
            'headers' => [
                'Authorization' => 'Bearer ' . $this->getAuthToken()->data->accessToken
            ]
        ]);
        return json_decode($response->getBody()->getContents());
    }

    /**
     * @param $approved
     * @param $code
     * @param $size
     * @param $page
     * @return mixed
     * @throws GuzzleException
     */
    public function products($approved = true, $code = null, $size = 100, $page = 1)
    {
        $response = $this->client->request('GET', self::API_URL . 'product/getProducts', [
            'query' => [
                'Approved' => $approved,
                'Code' => $code,
                'Size' => $size,
                'Page' => $page
            ],
            'headers' => [
                'Authorization' => 'Bearer ' . $this->getAuthToken()->data->accessToken
            ]
        ]);
        return json_decode($response->getBody()->getContents());
    }

    /**
     * @param $startDate
     * @param $endDate
     * @return mixed
     * @throws GuzzleException
     */
    public function orders($startDate, $endDate)
    {
        $response = $this->client->request('POST', self::API_URL . '/order/getOrdersForApi',[
            'form_params' => [
                'StartDate' => $startDate,
                'EndDate' => $endDate,
                'Page' => 1,
                'Size' => 100
            ],
            'headers' => [
                'Authorization' => 'Bearer ' . $this->getAuthToken()->data->accessToken
            ]
        ]);
        return json_decode($response->getBody()->getContents());
    }

}