<?php

namespace Tests\Unit;

use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Response;
use Luanrodrigues\LaravelEvolution\EvolutionApi;
use PHPUnit\Framework\TestCase;
use Mockery;

class EvolutionApiTest extends TestCase
{
    protected $clientMock;
    protected $api;

    protected function setUp(): void
    {
        parent::setUp();

        // Criar um mock do Guzzle Client
        $this->clientMock = Mockery::mock(Client::class);

        // Inicializar a classe EvolutionApi
        $this->api = new EvolutionApi('https://api.example.com', 'test-api-key');

        // Injetar o cliente mockado usando o método setClient
        $this->api->setClient($this->clientMock);
    }

    public function tearDown(): void
    {
        Mockery::close();
        parent::tearDown();
    }

    public function testGetRequestSuccess()
    {
        $endpoint = '/test-endpoint';
        $params = ['param1' => 'value1'];
        $responseBody = ['status' => 'success'];

        // Configura o mock para esperar a chamada ao método request
        $this->clientMock->shouldReceive('request')
            ->once()
            ->with('GET', $endpoint, ['query' => $params])
            ->andReturn(new Response(200, [], json_encode($responseBody)));

        // Executa o método e verifica o resultado
        $response = $this->api->get($endpoint, $params);

        $this->assertEquals($responseBody, $response);
    }

    public function testPostRequestSuccess()
    {
        $endpoint = '/test-endpoint';
        $data = ['key' => 'value'];
        $responseBody = ['status' => 'created'];

        // Configura o mock para esperar a chamada ao método request
        $this->clientMock->shouldReceive('request')
            ->once()
            ->with('POST', $endpoint, ['json' => $data])
            ->andReturn(new Response(200, [], json_encode($responseBody)));

        // Executa o método e verifica o resultado
        $response = $this->api->post($endpoint, $data);

        $this->assertEquals($responseBody, $response);
    }

    public function testDeleteRequestSuccess()
    {
        $endpoint = '/test-endpoint';
        $data = ['key' => 'value'];
        $responseBody = ['status' => 'deleted'];

        // Configura o mock para esperar a chamada ao método request
        $this->clientMock->shouldReceive('request')
            ->once()
            ->with('DELETE', $endpoint, ['json' => $data])
            ->andReturn(new Response(200, [], json_encode($responseBody)));

        // Executa o método e verifica o resultado
        $response = $this->api->delete($endpoint, $data);

        $this->assertEquals($responseBody, $response);
    }

    public function testGetRequestException()
    {
        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('Erro ao fazer requisição GET:');

        $endpoint = '/test-endpoint';

        // Configura o mock para lançar uma exceção
        $this->clientMock->shouldReceive('request')
            ->once()
            ->with('GET', $endpoint, ['query' => []])
            ->andThrow(new \Exception('Erro ao fazer requisição GET: Erro simulado'));

        // Executa o método (deve lançar exceção)
        $this->api->get($endpoint);
    }

    public function testPostRequestException()
    {
        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('Erro ao fazer requisição POST:');

        $endpoint = '/test-endpoint';
        $data = ['key' => 'value'];

        // Configura o mock para lançar uma exceção
        $this->clientMock->shouldReceive('request')
            ->once()
            ->with('POST', $endpoint, ['json' => $data])
            ->andThrow(new \Exception('Erro ao fazer requisição POST: Erro simulado'));

        // Executa o método (deve lançar exceção)
        $this->api->post($endpoint, $data);
    }

    public function testDeleteRequestException()
    {
        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('Erro ao fazer requisição DELETE:');

        $endpoint = '/test-endpoint';
        $data = ['key' => 'value'];

        // Configura o mock para lançar uma exceção
        $this->clientMock->shouldReceive('request')
            ->once()
            ->with('DELETE', $endpoint, ['json' => $data])
            ->andThrow(new \Exception('Erro ao fazer requisição DELETE: Erro simulado'));

        // Executa o método (deve lançar exceção)
        $this->api->delete($endpoint, $data);
    }
}
