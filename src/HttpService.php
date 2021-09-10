<?php

declare(strict_types=1);

namespace DevMakerLab\MyMine;

use GuzzleHttp\Client;

class HttpService
{
    protected Client $client;

    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    public function get(string $endpoint): ?array
    {
        return $this->request($endpoint, 'GET');
    }

    public function post(string $endpoint, array $parameters = []): ?array
    {
        return $this->request($endpoint, 'POST', $parameters);
    }

    public function put(string $endpoint, array $parameters = []): ?array
    {
        return $this->request($endpoint, 'PUT', $parameters);
    }

    public function delete(string $endpoint, array $parameters = []): ?array
    {
        return $this->request($endpoint, 'DELETE', $parameters);
    }

    public function patch(string $endpoint, array $parameters = []): ?array
    {
        return $this->request($endpoint, 'PATCH', $parameters);
    }

    private function request(string $endpoint, string $method, array $params = []): ?array
    {
        $response = $this->client->request($method, $endpoint, [
            'form_params' => $params,
        ]);

        $json = $response->getBody()->getContents();
        return json_decode($json, true);
    }
}
