<?php

declare(strict_types=1);

namespace Tests\Unit;

use Mockery;
use Tests\TestCase;
use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Response;
use DevMakerLab\MyMine\HttpService;

class HttpServiceTest extends TestCase
{
    public function testCanSendGetRequest(): void
    {
        $json = json_encode(['foo']);
        $uri = 'foo.com';
        $method = 'GET';

        $httpService = $this->httpService($uri, $method, $json);
        $response = $httpService->get('foo.com');

        $this->assertSame(['foo'], $response);
    }

    public function testCanSendPostRequest(): void
    {
        $json = json_encode(['foo']);
        $uri = 'foo.com';
        $method = 'POST';

        $httpService = $this->httpService($uri, $method, $json);
        $response = $httpService->post('foo.com');

        $this->assertSame(['foo'], $response);
    }

    public function testCanSendPutRequest(): void
    {
        $json = json_encode(['foo']);
        $uri = 'foo.com';
        $method = 'PUT';

        $httpService = $this->httpService($uri, $method, $json);
        $response = $httpService->put('foo.com');

        $this->assertSame(['foo'], $response);
    }

    public function testCanSendDeleteRequest(): void
    {
        $json = json_encode(['foo']);
        $uri = 'foo.com';
        $method = 'DELETE';

        $httpService = $this->httpService($uri, $method, $json);
        $response = $httpService->delete('foo.com');

        $this->assertSame(['foo'], $response);
    }

    public function testCanSendPatchRequest(): void
    {
        $json = json_encode(['foo']);
        $uri = 'foo.com';
        $method = 'PATCH';

        $httpService = $this->httpService($uri, $method, $json);
        $response = $httpService->patch('foo.com');

        $this->assertSame(['foo'], $response);
    }

    protected function httpService(string $endpoint, string $method, string $response): HttpService
    {
        $guzzle = Mockery::mock(Client::class);
        $guzzle->shouldReceive('request')
            ->once()
            ->withArgs([$method, $endpoint, ['form_params' => []]])
            ->andReturn(new Response(200, ['Content-Type' => 'application/json'], $response));

        return $this->getHttpService($guzzle);
    }
}
