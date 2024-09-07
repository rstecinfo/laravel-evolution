<?php

namespace Tests\Unit;

use Luanrodrigues\LaravelEvolution\Services\SettingsService;
use Luanrodrigues\LaravelEvolution\EvolutionApi;
use PHPUnit\Framework\TestCase;
use Mockery;

class SettingsServiceTest extends TestCase
{
    /**
     * @var Mockery\MockInterface|EvolutionApi
     */
    protected $apiMock;

    /**
     * @var SettingsService
     */
    protected $service;

    protected function setUp(): void
    {
        parent::setUp();

        // Criar um mock do EvolutionApi
        $this->apiMock = Mockery::mock(EvolutionApi::class);

        // Inicializar o serviço com o mock
        $this->service = new SettingsService($this->apiMock);
    }

    public function tearDown(): void
    {
        Mockery::close();
        parent::tearDown();
    }

    public function testSetSettings()
    {
        $instance = 'test-instance';
        $settings = [
            'theme' => 'dark',
            'notifications' => true,
        ];

        // Configura o mock para esperar a chamada ao método post
        $this->apiMock->shouldReceive('post')
            ->once()
            ->with("/settings/set/{$instance}", $settings)
            ->andReturn(['status' => 'success']);

        // Executa o método e verifica o resultado
        $response = $this->service->setSettings($settings, $instance);

        $this->assertEquals(['status' => 'success'], $response);
    }

    public function testFindSettings()
    {
        $instance = 'test-instance';
        $expectedResponse = [
            'theme' => 'dark',
            'notifications' => true,
        ];

        // Configura o mock para esperar a chamada ao método get
        $this->apiMock->shouldReceive('get')
            ->once()
            ->with("/settings/find/{$instance}")
            ->andReturn($expectedResponse);

        // Executa o método e verifica o resultado
        $response = $this->service->findSettings($instance);

        $this->assertEquals($expectedResponse, $response);
    }
}
