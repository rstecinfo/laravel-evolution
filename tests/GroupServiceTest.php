<?php

namespace Tests\Unit;

use Luanrodrigues\LaravelEvolution\Services\GroupService;
use Luanrodrigues\LaravelEvolution\EvolutionApi;
use PHPUnit\Framework\TestCase;
use Mockery;

class GroupServiceTest extends TestCase
{
    /**
     * @var Mockery\MockInterface|EvolutionApi
     */
    protected $apiMock;

    /**
     * @var GroupService
     */
    protected $service;

    protected function setUp(): void
    {
        parent::setUp();

        // Criar um mock do EvolutionApi
        $this->apiMock = Mockery::mock(EvolutionApi::class);

        // Inicializar o serviço com o mock
        $this->service = new GroupService($this->apiMock);
    }

    public function tearDown(): void
    {
        Mockery::close();
        parent::tearDown();
    }

    public function testCreateGroup()
    {
        $instance = 'test-instance';
        $subject = 'Test Group';
        $participants = ['participant1', 'participant2'];
        $description = 'Group Description';

        $expectedData = [
            'subject' => $subject,
            'description' => $description,
            'participants' => $participants,
        ];

        // Configura o mock para esperar a chamada ao método post
        $this->apiMock->shouldReceive('post')
            ->once()
            ->with("/group/create/{$instance}", $expectedData)
            ->andReturn(['status' => 'success']);

        // Executa o método e verifica o resultado
        $response = $this->service->createGroup($instance, $subject, $participants, $description);

        $this->assertEquals(['status' => 'success'], $response);
    }

    public function testUpdateGroupSubject()
    {
        $instance = 'test-instance';
        $groupJid = 'group@jid';
        $subject = 'New Group Name';

        $expectedData = ['subject' => $subject];

        // Configura o mock para esperar a chamada ao método post
        $this->apiMock->shouldReceive('post')
            ->once()
            ->with("/group/updateGroupSubject/{$instance}?groupJid={$groupJid}", $expectedData)
            ->andReturn(['status' => 'success']);

        // Executa o método e verifica o resultado
        $response = $this->service->updateGroupSubject($instance, $groupJid, $subject);

        $this->assertEquals(['status' => 'success'], $response);
    }

    public function testUpdateGroupDescription()
    {
        $instance = 'test-instance';
        $groupJid = 'group@jid';
        $description = 'New Description';

        $expectedData = ['description' => $description];

        // Configura o mock para esperar a chamada ao método post
        $this->apiMock->shouldReceive('post')
            ->once()
            ->with("/group/updateGroupDescription/{$instance}?groupJid={$groupJid}", $expectedData)
            ->andReturn(['status' => 'success']);

        // Executa o método e verifica o resultado
        $response = $this->service->updateGroupDescription($instance, $groupJid, $description);

        $this->assertEquals(['status' => 'success'], $response);
    }

    public function testFetchAllGroups()
    {
        $instance = 'test-instance';
        $getParticipants = true;

        $expectedParams = ['getParticipants' => 'true'];

        // Configura o mock para esperar a chamada ao método get
        $this->apiMock->shouldReceive('get')
            ->once()
            ->with("/group/fetchAllGroups/{$instance}", $expectedParams)
            ->andReturn(['groups' => []]);

        // Executa o método e verifica o resultado
        $response = $this->service->fetchAllGroups($instance, $getParticipants);

        $this->assertEquals(['groups' => []], $response);
    }

    public function testFindParticipants()
    {
        $instance = 'test-instance';
        $groupJid = 'group@jid';

        $expectedParams = ['groupJid' => $groupJid];

        // Configura o mock para esperar a chamada ao método get
        $this->apiMock->shouldReceive('get')
            ->once()
            ->with("/group/participants/{$instance}", $expectedParams)
            ->andReturn(['participants' => []]);

        // Executa o método e verifica o resultado
        $response = $this->service->findParticipants($instance, $groupJid);

        $this->assertEquals(['participants' => []], $response);
    }

    public function testUpdateParticipants()
    {
        $instance = 'test-instance';
        $groupJid = 'group@jid';
        $action = 'add';
        $participants = ['participant1', 'participant2'];

        $expectedData = [
            'action' => $action,
            'participants' => $participants,
        ];

        // Configura o mock para esperar a chamada ao método post
        $this->apiMock->shouldReceive('post')
            ->once()
            ->with("/group/updateParticipant/{$instance}?groupJid={$groupJid}", $expectedData)
            ->andReturn(['status' => 'success']);

        // Executa o método e verifica o resultado
        $response = $this->service->updateParticipants($instance, $groupJid, $action, $participants);

        $this->assertEquals(['status' => 'success'], $response);
    }

    public function testLeaveGroup()
    {
        $instance = 'test-instance';
        $groupJid = 'group@jid';

        // Configura o mock para esperar a chamada ao método delete
        $this->apiMock->shouldReceive('delete')
            ->once()
            ->with("/group/leaveGroup/{$instance}?groupJid={$groupJid}")
            ->andReturn(['status' => 'success']);

        // Executa o método e verifica o resultado
        $response = $this->service->leaveGroup($instance, $groupJid);

        $this->assertEquals(['status' => 'success'], $response);
    }
}
