<?php

namespace JiraApi\Clients;

use GuzzleHttp\Client as GuzzleClient;

abstract class AbstractClient
{
    const AUTH_HTTP_PASSWORD = 'http_password';
    const AUTH_HTTP_TOKEN = 'http_token';

    /**
     * @var GuzzleClient
     */
    protected $client;

    /**
     * Receives url, username and password for the connection
     *
     * "url": "https://myproject.atlassian.com/rest/api/latest/"
     *
     * @param string $url
     * @param string $username
     * @param string $password
     */
    public function __construct($url, $username, $password)
    {
        $this->client = new GuzzleClient(
            [
                'base_url' => rtrim($url, '/') . '/',
                'defaults' => [
                    'auth' => [$username, $password]
                ]
            ]
        );
    }

    /**
     * @return GuzzleClient
     */
    public function getClient()
    {
        return $this->client;
    }

    /**
     * @param  string $uri
     *
     * @return \GuzzleHttp\Message\Response
     */
    public function getRequest($uri)
    {
        return $this->getClient()->get($uri);
    }

    /**
     * @param  string $uri
     * @param  array $data
     *
     * @return \GuzzleHttp\Message\Response
     */
    public function postRequest($uri, array $data = null)
    {
        return $this->getClient()->post($uri, [
            'json' => $this->createBody($data)
        ]);
    }

    /**
     * @param  string $uri
     * @param array $data
     *
     * @return \GuzzleHttp\Message\Response
     */
    public function putRequest($uri, array $data = null)
    {
        return $this->getClient()->put($uri, [
            'json' => $this->createBody($data)
        ]);
    }

    /**
     * @param  string $uri
     *
     * @return \GuzzleHttp\Message\Response
     */
    public function deleteRequest($uri)
    {
        return $this->getClient()->delete($uri);
    }

    /**
     * @param  array  $data
     *
     * @return array
     */
    protected function createBody(array $data = null)
    {
        return $data ?: [];
    }

    /**
     * @param  array  $data
     *
     * @return string
     */
    protected function createUriParameters(array $data = null)
    {
        return $data ? http_build_query($data) : '';
    }
}
