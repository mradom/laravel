<?php

namespace App\Helpers;

use Config;
use Illuminate\Http\Request;

class ApiHelper
{
    protected $client;

    public function __construct(\GuzzleHttp\Client $client)
    {
        $this->client = $client;
    }

    /**
     * Send get request to the api.
     *
     * @param string $path
     * @param array $headers
     *
     * @return \Guzzle\Http\Message\Response
     */
    public function get($path, $headers = [])
    {
        $uri = $this->getUri($path);

        return $this->client->get($uri, $headers);
    }

    /**
     * Send put request to the api.
     *
     * @param string $path
     * @param array $data
     *
     * @return \Guzzle\Http\Message\Response
     */
    public function put($path, $data = [])
    {
        $uri = $this->getUri($path);

        return $this->client->put($uri, ['form_params' => $data]);
    }

    /**
     * Send post request to the api.
     *
     * @param string $path
     * @param array $data
     *
     * @return \Guzzle\Http\Message\Response
     */
    public function post($path, $data = [])
    {
        $uri = $this->getUri($path);

        return $this->client->post($uri, ['form_params' => $data]);
    }

    /**
     * Get URI for the path.
     *
     * @param string $path
     *
     * @return string
     */
    public static function getUri($path)
    {
        return Config::get('app.url') . $path;
    }
}
