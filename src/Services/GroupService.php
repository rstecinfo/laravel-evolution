<?php

namespace Luanrodrigues\LaravelEvolution\Services;

use Luanrodrigues\LaravelEvolution\EvolutionApi;

class GroupService
{
    /**
     * @var EvolutionApi
     */
    protected EvolutionApi $api;

    /**
     * @var string Nome da Instância API Evolution
     */
    protected string $instance;

    /**
     * GroupService constructor.
     *
     * Inicializa o serviço com uma instância de EvolutionApi.
     *
     * @param EvolutionApi $api
     * @param string $instance
     */
    public function __construct(EvolutionApi $api, string $instance)
    {
        $this->api = $api;
        $this->instance = $instance;
    }

    /**
     * Define a instância da API Evolution.
     *
     * @param string $instance ID da instância
     * @return $this
     * @throws \InvalidArgumentException Se o ID da instância for inválido
     */
    public function setInstance(string $instance)
    {
        // Verificação básica se a instância não é uma string vazia
        if (empty($instance)) {
            throw new \InvalidArgumentException("A instância não pode ser vazio.");
        }

        $this->instance = $instance;
        return $this;
    }

    /**
     * Cria um novo grupo.
     * Este método cria um grupo com um assunto, descrição opcional e uma lista de participantes.
     *
     * Estrutura 'body':
     * - "subject": Nome do grupo.
     * - "description": (Opcional) Descrição do grupo.
     * - "participants": Lista de participantes no formato de números de
     * telefone.
     * @param string $subject Nome do grupo
     * @param array $participants Lista de participantes
     * @param string|null $description (Opcional) Descrição do grupo
     * @return array Resposta da API
     */
    public function createGroup(string $subject, array $participants, ?string $description = null): array
    {
        $data = [
            'subject' => $subject,
            'description' => $description,
            'participants' => $participants,
        ];

        return $this->api->post("/group/create/{$this->instance}", $data);
    }

    /**
     * Atualiza o nome de um grupo.
     *
     * @param string $groupJid JID do grupo
     * @param string $subject Novo nome do grupo
     * @return array Resposta da API
     */
    public function updateGroupSubject(string $groupJid, string $subject): array
    {
        $data = ['subject' => $subject];

        return $this->api->post("/group/updateGroupSubject/{$this->instance}?groupJid={$groupJid}", $data);
    }

    /**
     * Atualiza a descrição de um grupo.
     *
     * @param string $groupJid JID do grupo
     * @param string $description Nova descrição do grupo
     * @return array Resposta da API
     */
    public function updateGroupDescription(string $groupJid, string $description): array
    {
        $data = ['description' => $description];

        return $this->api->post("/group/updateGroupDescription/{$this->instance}?groupJid={$groupJid}", $data);
    }

    /**
     * Busca todos os grupos da instância.
     *
     * @param bool $getParticipants (Opcional) Se deve incluir participantes
     * @return array Resposta da API
     */
    public function fetchAllGroups(bool $getParticipants = false): array
    {
        $params = ['getParticipants' => $getParticipants ? 'true' : 'false'];

        return $this->api->get("/group/fetchAllGroups/{$this->instance}", $params);
    }

    /**
     * Encontra participantes de um grupo.
     *
     * @param string $groupJid JID do grupo
     * @return array Resposta da API
     */
    public function findParticipants(string $groupJid): array
    {
        $params = ['groupJid' => $groupJid];

        return $this->api->get("/group/participants/{$this->instance}", $params);
    }

    /**
     * Atualiza participantes de um grupo.
     *
     * @param string $groupJid JID do grupo
     * @param string $action Ação a ser realizada (add, remove, promote, demote)
     * @param array $participants Lista de participantes
     * @return array Resposta da API
     */
    public function updateParticipants(string $groupJid, string $action, array $participants): array
    {
        $data = [
            'action' => $action,
            'participants' => $participants,
        ];

        return $this->api->post("/group/updateParticipant/{$this->instance}?groupJid={$groupJid}", $data);
    }

    /**
     * Remove o usuário do grupo.
     *
     * @param string $groupJid JID do grupo
     * @return array Resposta da API
     */
    public function leaveGroup(string $groupJid): array
    {
        return $this->api->delete("/group/leaveGroup/{$this->instance}?groupJid={$groupJid}");
    }

    /**
     * Busca o código de convite do grupo.
     *
     * @param string $groupJid JID do grupo
     * @return array Resposta da API
     */
    public function fetchInviteCode(string $groupJid): array
    {
        return $this->api->get("/group/inviteCode/{$this->instance}", ['groupJid' => $groupJid]);
    }

    /**
     * Revoga o código de convite do grupo.
     *
     * @param string $groupJid JID do grupo
     * @return array Resposta da API
     */
    public function revokeInviteCode(string $groupJid): array
    {
        return $this->api->post("/group/revokeInviteCode/{$this->instance}", ['groupJid' => $groupJid]);
    }

    /**
     * Envia a URL de convite para o grupo.
     *
     * @param string $groupJid JID do grupo
     * @param string $description Descrição do convite
     * @param array $numbers Lista de números de telefone para os quais o convite será enviado
     * @return array Resposta da API
     */
    public function sendInviteUrl(string $groupJid, string $description, array $numbers): array
    {
        $data = [
            'groupJid' => $groupJid,
            'description' => $description,
            'numbers' => $numbers,
        ];

        return $this->api->post("/group/sendInviteUrl/{$this->instance}", $data);
    }

    /**
     * Encontra grupo pelo código de convite.
     *
     * @param string $inviteCode Código de convite do grupo
     * @return array Resposta da API
     */
    public function findGroupByInviteCode(string $inviteCode): array
    {
        return $this->api->get("/group/findByInviteCode/{$this->instance}", ['inviteCode' => $inviteCode]);
    }

    /**
     * Encontra grupo pelo JID.
     *
     * @param string $groupJid JID do grupo
     * @return array Resposta da API
     */
    public function findGroupByJid(string $groupJid): array
    {
        return $this->api->get("/group/findByJid/{$this->instance}", ['groupJid' => $groupJid]);
    }

    /**
     * Atualiza as configurações de um grupo.
     *
     * Este método permite que você atualize as configurações de um grupo, como definir permissões de quem pode
     * enviar mensagens ou editar configurações do grupo.
     *
     * Estrutura do campo 'settings':
     * - "announcement" = Somente os administradores podem enviar mensagens.
     * - "not_announcement" = Todos os membros podem enviar mensagens.
     * - "locked" = Somente os administradores podem editar as configurações do grupo.
     * - "unlocked" = Todos os membros podem editar as configurações do grupo.
     *
     * @param string $groupJid JID do grupo
     * @param string $action Ação a ser aplicada ao grupo (announcement, not_announcement, locked, unlocked)
     * @return array Resposta da API
     */
    public function updateGroupSetting(string $groupJid, array $settings): array
    {
        $data = [
            'groupJid' => $groupJid,
            'settings' => $settings,
        ];

        return $this->api->post("/group/updateSetting/{$this->instance}", $data);
    }

    /**
     * Atualiza a imagem de um grupo.
     *
     * Este método permite que você atualize a imagem de um grupo do WhatsApp.
     * A imagem pode ser enviada em formato base64 ou via URL.
     *
     * Estrutura do campo 'body':
     * - "image": URL da imagem.
     *
     * @param string $groupJid JID do grupo
     * @param string $imageUrl URL da imagem
     * @return array Resposta da API
     */
    public function updateGroupPicture(string $groupJid, string $imageUrl): array
    {
        $data = [
            'image' => $imageUrl, // URL da imagem
        ];

        return $this->api->post("/group/updateGroupPicture/{$this->instance}?groupJid={$groupJid}", $data);
    }
}
