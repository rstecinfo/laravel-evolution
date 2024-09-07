<?php

namespace Tests\Unit;

use Luanrodrigues\LaravelEvolution\Services\SendMessageService;
use Luanrodrigues\LaravelEvolution\EvolutionApi;
use PHPUnit\Framework\TestCase;
use Mockery;

class SendMessageServiceTest extends TestCase
{
    /**
     * @var Mockery\MockInterface|EvolutionApi
     */
    protected $apiMock;

    /**
     * @var SendMessageService
     */
    protected $service;

    protected function setUp(): void
    {
        parent::setUp();

        // Criar um mock do EvolutionApi
        $this->apiMock = Mockery::mock(EvolutionApi::class);

        // Inicializar o serviço com o mock
        $this->service = new SendMessageService($this->apiMock);
    }

    public function tearDown(): void
    {
        Mockery::close();
        parent::tearDown();
    }

    public function testSendText()
    {
        $instance = 'test-instance';
        $number = '5599999999999';
        $message = 'Hello, this is a test message!';
        $expectedData = [
            'number' => $number,
            'text' => $message,
        ];

        // Configura o mock para esperar a chamada ao método post
        $this->apiMock->shouldReceive('post')
            ->once()
            ->with("/message/sendText/$instance", $expectedData)
            ->andReturn(['status' => 'success']);

        // Executa o método e verifica o resultado
        $response = $this->service->sendText($instance, $number, $message);

        $this->assertEquals(['status' => 'success'], $response);
    }

    public function testSendMedia()
    {
        $instance = 'test-instance';
        $number = '5599999999999';
        $mediaUrl = 'http://example.com/image.png';
        $mediaType = 'image';
        $mimeType = 'image/png';
        $caption = 'Check this out!';
        $expectedData = [
            'number' => $number,
            'media' => $mediaUrl,
            'mediatype' => $mediaType,
            'mimetype' => $mimeType,
            'caption' => $caption,
        ];

        // Configura o mock para esperar a chamada ao método post
        $this->apiMock->shouldReceive('post')
            ->once()
            ->with("/message/sendMedia/$instance", $expectedData)
            ->andReturn(['status' => 'success']);

        // Executa o método e verifica o resultado
        $response = $this->service->sendMedia($instance, $number, $mediaUrl, $mediaType, $mimeType, $caption);

        $this->assertEquals(['status' => 'success'], $response);
    }

    public function testSendAudio()
    {
        $instance = 'test-instance';
        $number = '5599999999999';
        $audioUrl = 'http://example.com/audio.mp3';
        $expectedData = [
            'number' => $number,
            'audio' => $audioUrl,
        ];

        // Configura o mock para esperar a chamada ao método post
        $this->apiMock->shouldReceive('post')
            ->once()
            ->with("/message/sendWhatsAppAudio/$instance", $expectedData)
            ->andReturn(['status' => 'success']);

        // Executa o método e verifica o resultado
        $response = $this->service->sendAudio($instance, $number, $audioUrl);

        $this->assertEquals(['status' => 'success'], $response);
    }

    public function testSendSticker()
    {
        $instance = 'test-instance';
        $number = '5599999999999';
        $stickerUrl = 'http://example.com/sticker.png';
        $expectedData = [
            'number' => $number,
            'sticker' => $stickerUrl,
        ];

        // Configura o mock para esperar a chamada ao método post
        $this->apiMock->shouldReceive('post')
            ->once()
            ->with("/message/sendSticker/$instance", $expectedData)
            ->andReturn(['status' => 'success']);

        // Executa o método e verifica o resultado
        $response = $this->service->sendSticker($instance, $number, $stickerUrl);

        $this->assertEquals(['status' => 'success'], $response);
    }

    public function testSendLocation()
    {
        $instance = 'test-instance';
        $number = '5599999999999';
        $name = 'Location Name';
        $address = '123 Main St';
        $latitude = -23.563210;
        $longitude = -46.654321;
        $expectedData = [
            'number' => $number,
            'name' => $name,
            'address' => $address,
            'latitude' => $latitude,
            'longitude' => $longitude,
        ];

        // Configura o mock para esperar a chamada ao método post
        $this->apiMock->shouldReceive('post')
            ->once()
            ->with("/message/sendLocation/$instance", $expectedData)
            ->andReturn(['status' => 'success']);

        // Executa o método e verifica o resultado
        $response = $this->service->sendLocation($instance, $number, $name, $address, $latitude, $longitude);

        $this->assertEquals(['status' => 'success'], $response);
    }

    public function testSendContact()
    {
        $instance = 'test-instance';
        $number = '5599999999999';
        $contacts = [
            ['name' => 'John Doe', 'phone' => '559988776655'],
        ];
        $expectedData = [
            'number' => $number,
            'contact' => $contacts,
        ];

        // Configura o mock para esperar a chamada ao método post
        $this->apiMock->shouldReceive('post')
            ->once()
            ->with("/message/sendContact/$instance", $expectedData)
            ->andReturn(['status' => 'success']);

        // Executa o método e verifica o resultado
        $response = $this->service->sendContact($instance, $number, $contacts);

        $this->assertEquals(['status' => 'success'], $response);
    }
}
