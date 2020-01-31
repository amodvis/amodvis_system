<?php

namespace ES\Net\Http;

class FpfHttpClient
{
    /**
     * @var  $http_client CurlHttpClient|SwoftHttpClient
     */
    private $http_client;

    public function __construct($config = [])
    {
        if (defined('IS_SWOOLE_SERVICE') && IS_SWOOLE_SERVICE === true) {
            $this->http_client = new SwooleHttpClient($config);
        } else {
            $this->http_client = new CurlHttpClient($config);
        }
    }

    public function get($url, $get_arr = [], $options = [])
    {
        return $this->http_client->get($url, $get_arr, $options);
    }

    public function post($url, $post_arr = [], $options = [])
    {
        return $this->http_client->post($url, $post_arr, $options);
    }
}
