<?php

namespace Tests\Unit;

use Luanrodrigues\LaravelEvolution\Services\EvolutionInstanceService;
use Luanrodrigues\LaravelEvolution\EvolutionApi;
use PHPUnit\Framework\TestCase;
use Mockery;

class EvolutionInstanceServiceTest extends TestCase
{
    /**
     * @var Mockery\MockInterface|EvolutionApi
     */
    protected $apiMock;

    /**
     * @var EvolutionInstanceService
     */
    protected $service;

    protected function setUp(): void
    {
        parent::setUp();

        // Criar um mock do EvolutionApi
        $this->apiMock = Mockery::mock(EvolutionApi::class);

        // Inicializar o serviço com o mock
        $this->service = new EvolutionInstanceService($this->apiMock);
    }

    public function tearDown(): void
    {
        Mockery::close();
        parent::tearDown();
    }

    public function testCreateInstance()
    {
        $instanceName = 'Test Instance';
        $qrcode = true;
        $integration = 'WHATSAPP-BAILEYS';
        $expectedData = [
            'instanceName' => $instanceName,
            'qrcode' => $qrcode,
            'integration' => $integration,
        ];

        // Configura o mock para esperar a chamada ao método post
        $this->apiMock->shouldReceive('post')
            ->once()
            ->with('/instance/create', $expectedData)
            ->andReturn(['status' => 'success']);

        // Executa o método e verifica o resultado
        $response = $this->service->createInstance($instanceName, $qrcode, $integration);

        $this->assertEquals(['status' => 'success'], $response);
    }

    public function testFetchInstances()
    {
        // Configura o mock para esperar a chamada ao método get
        $this->apiMock->shouldReceive('get')
            ->once()
            ->with('/instance/fetchInstances')
            ->andReturn(['instances' => []]);

        // Executa o método e verifica o resultado
        $response = $this->service->fetchInstances();

        $this->assertEquals(['instances' => []], $response);
    }

    public function testConnectInstance()
    {
        $instance = 'test-instance';

        // Configura o mock para esperar a chamada ao método get
        $this->apiMock->shouldReceive('get')
            ->once()
            ->with("/instance/connect/{$instance}")
            ->andReturn(['status' => 'connected']);

        // Executa o método e verifica o resultado
        $response = $this->service->connectInstance($instance);

        $this->assertEquals(['status' => 'connected'], $response);
    }

    public function testRestartInstance()
    {
        $instance = 'test-instance';

        // Configura o mock para esperar a chamada ao método post
        $this->apiMock->shouldReceive('post')
            ->once()
            ->with("/instance/restart/{$instance}")
            ->andReturn(['status' => 'restarted']);

        // Executa o método e verifica o resultado
        $response = $this->service->restartInstance($instance);

        $this->assertEquals(['status' => 'restarted'], $response);
    }

    public function testSetPresence()
    {
        $instance = 'test-instance';
        $presence = 'online';
        $expectedData = [
            'presence' => $presence,
        ];

        // Configura o mock para esperar a chamada ao método post
        $this->apiMock->shouldReceive('post')
            ->once()
            ->with("/instance/setPresence/{$instance}", $expectedData)
            ->andReturn(['status' => 'presence_set']);

        // Executa o método e verifica o resultado
        $response = $this->service->setPresence($instance, $presence);

        $this->assertEquals(['status' => 'presence_set'], $response);
    }

    public function testGetConnectionStatus()
    {
        $instance = 'test-instance';

        // Configura o mock para esperar a chamada ao método get
        $this->apiMock->shouldReceive('get')
            ->once()
            ->with("/instance/connectionState/{$instance}")
            ->andReturn(['status' => 'connected']);

        // Executa o método e verifica o resultado
        $response = $this->service->getConnectionStatus($instance);

        $this->assertEquals(['status' => 'connected'], $response);
    }

    public function testLogoutInstance()
    {
        $instance = 'test-instance';

        // Configura o mock para esperar a chamada ao método delete
        $this->apiMock->shouldReceive('delete')
            ->once()
            ->with("/instance/logout/{$instance}")
            ->andReturn(['status' => 'logged_out']);

        // Executa o método e verifica o resultado
        $response = $this->service->logoutInstance($instance);

        $this->assertEquals(['status' => 'logged_out'], $response);
    }

    public function testDeleteInstance()
    {
        $instance = 'test-instance';

        // Configura o mock para esperar a chamada ao método delete
        $this->apiMock->shouldReceive('delete')
            ->once()
            ->with("/instance/delete/{$instance}")
            ->andReturn(['status' => 'deleted']);

        // Executa o método e verifica o resultado
        $response = $this->service->deleteInstance($instance);

        $this->assertEquals(['status' => 'deleted'], $response);
    }
}
